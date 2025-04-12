import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

const DataList = ({ 
    title, 
    data, 
    columns, 
    createPath, 
    onDelete, 
    editPathPrefix = '',
    detailPathPrefix = '',
    isLoading = false,
    error = null
}) => {
    const navigate = useNavigate();

    if (isLoading) {
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

    return (
        <div className="container mx-auto px-4 py-8">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold text-gray-800">{title}</h1>
                <Link
                    to={createPath}
                    className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"
                >
                    생성
                </Link>
            </div>

            <div className="bg-white shadow-md rounded-lg overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            {columns.map((column) => (
                                <th 
                                    key={column.key}
                                    className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    {column.label}
                                </th>
                            ))}
                            <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                작업
                            </th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {data && data.length > 0 ? (
                            data.map((item) => (
                                <tr 
                                    key={item.id}
                                    className="hover:bg-gray-50 cursor-pointer"
                                    onClick={() => navigate(`${detailPathPrefix}/${item.id}`)}
                                >
                                    {columns.map((column) => (
                                        <td 
                                            key={column.key}
                                            className="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                        >
                                            {item[column.key]}
                                        </td>
                                    ))}
                                    <td 
                                        className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        onClick={(e) => e.stopPropagation()}
                                    >
                                        <Link
                                            to={`${editPathPrefix}/${item.id}/edit`}
                                            className="text-indigo-600 hover:text-indigo-900 mr-4"
                                        >
                                            수정
                                        </Link>
                                        <button
                                            onClick={() => onDelete(item.id)}
                                            className="text-red-600 hover:text-red-900"
                                        >
                                            삭제
                                        </button>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={columns.length + 1} className="px-6 py-4 text-center text-sm text-gray-500">
                                    데이터가 없습니다.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default DataList; 