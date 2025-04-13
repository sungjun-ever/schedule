import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import Form from '../components/Form';

const TeamEdit = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const [formData, setFormData] = useState({
        teamName: '',
        description: ''
    });
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/teams/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const teamData = response.data.data;
                setFormData({
                    teamName: teamData.teamName || '',
                    description: teamData.description || ''
                });
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
            await axios.put(`/api/teams/${id}`, formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            navigate('/teams');
        } catch (error) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ submit: '팀 정보 수정에 실패했습니다.' });
            }
        }
    };

    const handleCancel = () => {
        navigate('/teams');
    };

    const fields = [
        {
            name: 'teamName',
            label: '팀 이름',
            type: 'text',
            onChange: handleChange
        },
        {
            name: 'description',
            label: '팀 설명',
            type: 'textarea',
            onChange: handleChange
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
            title="팀 정보 수정"
            fields={fields}
            onSubmit={handleSubmit}
            onCancel={handleCancel}
            initialData={formData}
            errors={errors}
            submitButtonText="수정"
        />
    );
};

export default TeamEdit; 