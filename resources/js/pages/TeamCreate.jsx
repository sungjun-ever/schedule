import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import Form from '../components/Form';

const TeamCreate = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        teamName: '',
        description: ''
    });
    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const token = localStorage.getItem('token');
            await axios.post('/api/teams', formData, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            navigate('/teams');
        } catch (error) {
            if (error.response?.data?.errors) {
                const backendErrors = error.response.data.errors;
                const formattedErrors = {
                    teamName: backendErrors.teamName || []
                };
                setErrors(formattedErrors);
            } else {
                setErrors({ teamName: ['팀 생성에 실패했습니다.'] });
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
            label: '설명',
            type: 'text',
            onChange: handleChange
        }
    ];

    return (
        <Form
            title="팀 생성"
            fields={fields}
            onSubmit={handleSubmit}
            onCancel={handleCancel}
            initialData={formData}
            errors={errors}
        />
    );
};

export default TeamCreate; 