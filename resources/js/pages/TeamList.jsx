import React, { useState, useEffect } from 'react';
import axios from 'axios';
import DataList from '../components/DataList';

const TeamList = () => {
    const [teams, setTeams] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchTeams = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/teams', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                
                const teamsData = response.data.data;
                setTeams(Array.isArray(teamsData) ? teamsData : []);
                setLoading(false);
            } catch (error) {
                console.error('API Error:', error);
                setError('팀 목록을 불러오는데 실패했습니다.');
                setLoading(false);
            }
        };

        fetchTeams();
    }, []);

    const handleDelete = async (teamId) => {
        try {
            const token = localStorage.getItem('token');
            await axios.delete(`/api/teams/${teamId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            setTeams(teams.filter(team => team.id !== teamId));
        } catch (error) {
            console.error('Delete Error:', error);
            setError('팀 삭제에 실패했습니다.');
        }
    };

    const columns = [
        { key: 'name', label: '팀 이름' },
        { key: 'description', label: '설명' },
        { key: 'member_count', label: '멤버 수' }
    ];

    return (
        <DataList
            title="팀 목록"
            data={teams}
            columns={columns}
            createPath="/teams/create"
            editPathPrefix="/teams"
            onDelete={handleDelete}
            isLoading={loading}
            error={error}
        />
    );
};

export default TeamList; 