import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import Form from '../components/Form';

const UserCreate = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        username: '',
        email: '',
        password: '',
        passwordConfirmation: '',
        level: '',
        teamId: ''
    });
    const [teams, setTeams] = useState([]);
    const [errors, setErrors] = useState({});

    useEffect(() => {
        const fetchTeams = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/teams', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                setTeams(response.data.data || []);
            } catch (error) {
                console.error('팀 목록을 불러오는데 실패했습니다:', error);
            }
        };

        fetchTeams();
    }, []);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});

        try {
            const token = localStorage.getItem('token');
            await axios.post('/api/users', formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            navigate('/users');
        } catch (error) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ submit: '회원 생성에 실패했습니다.' });
            }
        }
    };

    const handleCancel = () => {
        navigate('/users');
    };

    const fields = [
        {
            name: 'name',
            label: '이름',
            type: 'text',
            onChange: handleChange
        },
        {
            name: 'email',
            label: '이메일',
            type: 'email',
            onChange: handleChange
        },
        {
            name: 'password',
            label: '비밀번호',
            type: 'password',
            onChange: handleChange
        },
        {
            name: 'passwordConfirmation',
            label: '비밀번호 확인',
            type: 'password',
            onChange: handleChange
        },
        {
            name: 'level',
            label: '권한',
            type: 'select',
            onChange: handleChange,
            options: [
                { value: 'admin', label: '관리자' },
                { value: 'user', label: '사용자' }
            ]
        },
        {
            name: 'teamId',
            label: '팀',
            type: 'select',
            onChange: handleChange,
            options: teams.map(team => ({
                value: team.id,
                label: team.teamName
            }))
        }
    ];

    return (
        <Form
            title="회원 생성"
            fields={fields}
            onSubmit={handleSubmit}
            onCancel={handleCancel}
            initialData={formData}
            errors={errors}
        />
    );
};

export default UserCreate; 