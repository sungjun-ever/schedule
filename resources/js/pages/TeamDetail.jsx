import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const TeamDetail = () => {
    const [team, setTeam] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const { id } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        const fetchTeam = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/teams/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                setTeam(response.data.data);
                setLoading(false);
            } catch (error) {
                console.error('API Error:', error);
                setError('팀 정보를 불러오는데 실패했습니다.');
                setLoading(false);
            }
        };

        fetchTeam();
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

    if (!team) {
        return (
            <div className="text-center py-4">
                팀을 찾을 수 없습니다.
            </div>
        );
    }

    return (
        <div className="container mx-auto px-4 py-8">
            <div className="max-w-4xl mx-auto">
                <div className="bg-white shadow-md rounded-lg p-6">
                    <h1 className="text-2xl font-bold text-gray-800 mb-6">팀 정보</h1>
                    <div className="space-y-4">
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">팀 이름</h2>
                            <p className="mt-1 text-lg text-gray-900">{team.teamName}</p>
                        </div>
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">설명</h2>
                            <p className="mt-1 text-lg text-gray-900">{team.description || '설명이 없습니다.'}</p>
                        </div>
                        <div>
                            <h2 className="text-sm font-medium text-gray-500">총 인원수</h2>
                            <p className="mt-1 text-lg text-gray-900">{team.users?.length || 0}명</p>
                        </div>
                        <div className="border-t border-gray-200 my-6"></div>
                        <div className="mt-6">
                            <h2 className="text-lg font-medium text-gray-700 mb-4">팀 멤버</h2>
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">이름</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">아이디</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {team.users?.map((user, index) => (
                                            <tr key={index}>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{user.name}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{user.email}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div className="mt-6 flex space-x-4">
                        <button
                            onClick={() => navigate(`/teams/${id}/edit`)}
                            className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"
                        >
                            수정
                        </button>
                        <button
                            onClick={() => navigate('/teams')}
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

export default TeamDetail; 