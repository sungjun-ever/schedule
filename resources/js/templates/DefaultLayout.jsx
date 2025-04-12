import React, { useEffect, useState } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { Provider, useDispatch, useSelector } from 'react-redux';
import store from '../store';
import { setUser, clearUser } from '../store/userSlice';
import Login from '../pages/Login';
import Header from '../organisms/Header';
import UserList from '../pages/UserList';
import TeamList from '../pages/TeamList';
import UserCreate from '../pages/UserCreate';
import axios from 'axios';

const AppContent = () => {
    const dispatch = useDispatch();
    const { isAuthenticated, user } = useSelector((state) => state.user);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const verifyToken = async () => {
            const token = localStorage.getItem('token');
            const userData = localStorage.getItem('user');

            if (token && userData) {
                try {
                    const response = await axios.get('/api/auth/status', {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    dispatch(setUser(response.data));
                } catch (error) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    dispatch(clearUser());
                }
            } else {
                dispatch(clearUser());
            }
            setIsLoading(false);
        };

        verifyToken();
    }, [dispatch]);

    const MainLayout = ({ children }) => (
        <div className="min-h-screen bg-gray-100">
            <Header user={user} />
            <main className="py-6">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {children}
                </div>
            </main>
        </div>
    );

    if (isLoading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900"></div>
            </div>
        );
    }

    return (
        <Router>
            <Routes>
                <Route path="/login" element={!isAuthenticated ? <Login /> : <Navigate to="/" />} />
                <Route 
                    path="/" 
                    element={
                        isAuthenticated ? 
                        <MainLayout>
                            <div>메인 페이지</div>
                        </MainLayout> : 
                        <Navigate to="/login" />
                    } 
                />
                <Route 
                    path="/users" 
                    element={
                        isAuthenticated ? 
                        <MainLayout>
                            <UserList />
                        </MainLayout> : 
                        <Navigate to="/login" />
                    } 
                />
                <Route 
                    path="/users/create" 
                    element={
                        isAuthenticated ? 
                        <MainLayout>
                            <UserCreate />
                        </MainLayout> : 
                        <Navigate to="/login" />
                    } 
                />
                <Route 
                    path="/teams" 
                    element={
                        isAuthenticated ? 
                        <MainLayout>
                            <TeamList />
                        </MainLayout> : 
                        <Navigate to="/login" />
                    } 
                />
            </Routes>
        </Router>
    );
};

const App = () => {
    return (
        <Provider store={store}>
            <AppContent />
        </Provider>
    );
};

export default App; 