import React, { useState, useEffect } from 'react';
import axios from 'axios';
import DataList from '../components/DataList';

const UserList = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchUsers = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/users', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                
                const usersData = response.data.data;
                setUsers(Array.isArray(usersData) ? usersData : []);
                setLoading(false);
            } catch (error) {
                console.error('API Error:', error);
                setError('회원 목록을 불러오는데 실패했습니다.');
                setLoading(false);
            }
        };

        fetchUsers();
    }, []);

    const handleDelete = async (userId) => {
        try {
            const token = localStorage.getItem('token');
            await axios.delete(`/api/users/${userId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            setUsers(users.filter(user => user.id !== userId));
        } catch (error) {
            console.error('Delete Error:', error);
            setError('회원 삭제에 실패했습니다.');
        }
    };

    const columns = [
        { key: 'name', label: '이름' },
        { key: 'email', label: '이메일' }
    ];

    return (
        <DataList
            title="회원 목록"
            data={users}
            columns={columns}
            createPath="/users/create"
            editPathPrefix="/users"
            detailPathPrefix="/users"
            onDelete={handleDelete}
            isLoading={loading}
            error={error}
        />
    );
};

export default UserList; 