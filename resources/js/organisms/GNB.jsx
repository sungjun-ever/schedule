import React, { useState } from 'react';
import { Link } from 'react-router-dom';

const GNB = () => {
    const [activeMenu, setActiveMenu] = useState(null);

    const handleMouseEnter = (menu) => {
        setActiveMenu(menu);
    };

    const handleMouseLeave = (e) => {
        // 현재 마우스가 서브메뉴 영역에 있는지 확인
        const relatedTarget = e.relatedTarget;
        if (relatedTarget && relatedTarget.closest('.submenu-container')) {
            return;
        }
        setActiveMenu(null);
    };

    return (
        <div className="flex items-center space-x-8">
            {/* 로고 */}
            <Link to="/" className="text-xl font-bold text-gray-800 hover:text-gray-600">
                일정관리
            </Link>
            
            {/* 메인 메뉴 */}
            <nav className="hidden md:flex space-x-8">
                <div 
                    className="relative"
                    onMouseEnter={() => handleMouseEnter('users')}
                    onMouseLeave={handleMouseLeave}
                >
                    <Link
                        to="/users"
                        className="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md"
                    >
                        회원관리
                    </Link>
                    {activeMenu === 'users' && (
                        <div 
                            className="submenu-container absolute left-0 mt-0 w-48 bg-white rounded-md shadow-lg py-1 z-10"
                            onMouseEnter={() => handleMouseEnter('users')}
                            onMouseLeave={handleMouseLeave}
                        >
                            <Link
                                to="/users"
                                className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                회원 목록
                            </Link>
                            <Link
                                to="/teams"
                                className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                팀 관리
                            </Link>
                        </div>
                    )}
                </div>
                <Link
                    to="/schedules"
                    className="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md"
                >
                    일정관리
                </Link>
            </nav>
        </div>
    );
};

export default GNB; 