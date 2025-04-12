import React from 'react';
import GNB from './GNB';
import UserMenu from '../atoms/UserMenu';

const Header = ({ user }) => {
    return (
        <header className="bg-white shadow">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    <GNB />
                    <UserMenu user={user} />
                </div>
            </div>
        </header>
    );
};

export default Header; 