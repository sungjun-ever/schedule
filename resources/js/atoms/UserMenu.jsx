import React from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const UserMenu = ({ user }) => {
    const navigate = useNavigate();

    const handleLogout = async () => {
        try {
            const token = localStorage.getItem('token');
            await axios.post('/api/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        } catch (error) {
            console.error('로그아웃 실패:', error);
        }
    };

    return (
        <div className="flex items-center space-x-4">
            <div className="flex items-center">
                <span className="text-sm font-medium text-gray-700">
                    {user?.name || 'Guest'} 님
                </span>
            </div>
            <button
                onClick={handleLogout}
                className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
            >
                로그아웃
            </button>
        </div>
    );
};

export default UserMenu; 