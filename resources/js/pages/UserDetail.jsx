import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const UserDetail = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const { id } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        const fetchUser = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/users/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                setUser(response.data.data);
                setLoading(false);
            } catch (error) {
                console.error('API Error:', error);
                setError('사용자 정보를 불러오는데 실패했습니다.');
                setLoading(false);
            }
        };

        fetchUser();
    }, [id]);

    if (loading) {
        return (
            <div className="flex justify-center items-center h-64">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900"></div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="text-red-500 text-center py-4">
                {error}
            </div>
        );
    }

    if (!user) {
        return (
            <div className="text-center py-4">
                사용자를 찾을 수 없습니다.
            </div>
        );
    }

    return (
        <div className="container mx-auto px-4 py-8">
            <div className="max-w-2xl mx-auto">
                <div className="bg-white shadow-md rounded-lg p-6">
                    <h1 className="text-2xl font-bold text-gray-800 mb-6">사용자 정보</h1>
                    <div className="space-y-4">
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">이름</h2>
                            <p className="mt-1 text-lg text-gray-900">{user.name}</p>
                        </div>
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">이메일</h2>
                            <p className="mt-1 text-lg text-gray-900">{user.email}</p>
                        </div>
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">권한</h2>
                            <p className="mt-1 text-lg text-gray-900">{user.level}</p>
                        </div>
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">팀</h2>
                            <p className="mt-1 text-lg text-gray-900">{user.team ? user.team : '없음'}</p>
                        </div>
                    </div>
                    <div className="mt-6">
                        <button
                            onClick={() => navigate('/users')}
                            className="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
                        >
                            목록으로
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default UserDetail; 