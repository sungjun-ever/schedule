import React from 'react';

const Form = ({ 
    title, 
    fields, 
    onSubmit, 
    onCancel, 
    cancelPath,
    initialData = {},
    errors = {}
}) => {
    return (
        <div className="container mx-auto px-4 py-8">
            <div className="max-w-2xl mx-auto">
                <h1 className="text-2xl font-bold text-gray-800 mb-6">{title}</h1>
                <form onSubmit={onSubmit} className="space-y-6">
                    {fields.map((field) => (
                        <div key={field.name}>
                            <label htmlFor={field.name} className="block text-sm font-medium text-gray-700">
                                {field.label}
                            </label>
                            <div className="mt-1">
                                {field.type === 'select' ? (
                                    <select
                                        id={field.name}
                                        name={field.name}
                                        className="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-white py-2 px-3"
                                        value={initialData[field.name] || ''}
                                        onChange={field.onChange}
                                    >
                                        <option value="">선택하세요</option>
                                        {field.options?.map((option) => (
                                            <option key={option.value} value={option.value}>
                                                {option.label}
                                            </option>
                                        ))}
                                    </select>
                                ) : (
                                    <input
                                        type={field.type}
                                        id={field.name}
                                        name={field.name}
                                        className="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-white py-2 px-3"
                                        value={initialData[field.name] || ''}
                                        onChange={field.onChange}
                                    />
                                )}
                            </div>
                            {errors[field.name] && (
                                <p className="mt-1 text-sm text-red-600">{errors[field.name]}</p>
                            )}
                        </div>
                    ))}
                    <div className="flex justify-end space-x-3">
                        <button
                            type="button"
                            onClick={onCancel}
                            className="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            취소
                        </button>
                        <button
                            type="submit"
                            className="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            생성
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Form; 