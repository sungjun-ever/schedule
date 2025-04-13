import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import Form from '../components/Form';

const UserEdit = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        passwordConfirmation: '',
        level: '',
        teamId: ''
    });
    const [teams, setTeams] = useState([]);
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const token = localStorage.getItem('token');
                const [userResponse, teamsResponse] = await Promise.all([
                    axios.get(`/api/users/${id}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    }),
                    axios.get('/api/teams', {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    })
                ]);

                const userData = userResponse.data.data;
                setFormData({
                    name: userData.name || '',
                    email: userData.email || '',
                    password: '',
                    passwordConfirmation: '',
                    level: userData.level || '',
                    teamId: userData.teamId || ''
                });
                setTeams(teamsResponse.data.data || []);
                setLoading(false);
            } catch (error) {
                console.error('데이터를 불러오는데 실패했습니다:', error);
                setErrors({ fetch: '데이터를 불러오는데 실패했습니다.' });
                setLoading(false);
            }
        };

        fetchData();
    }, [id]);

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
            await axios.put(`/api/users/${id}`, formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            navigate('/users');
        } catch (error) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ submit: '회원 정보 수정에 실패했습니다.' });
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
            label: '새 비밀번호',
            type: 'password',
            onChange: handleChange,
            placeholder: '변경할 경우에만 입력하세요'
        },
        {
            name: 'passwordConfirmation',
            label: '새 비밀번호 확인',
            type: 'password',
            onChange: handleChange,
            placeholder: '변경할 경우에만 입력하세요'
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

    if (loading) {
        return (
            <div className="flex justify-center items-center h-64">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900"></div>
            </div>
        );
    }

    return (
        <Form
            title="회원 정보 수정"
            fields={fields}
            onSubmit={handleSubmit}
            onCancel={handleCancel}
            initialData={formData}
            errors={errors}
            submitButtonText="수정"
        />
    );
};

export default UserEdit; 