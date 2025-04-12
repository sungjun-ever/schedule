import './bootstrap';
import '../css/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './templates/DefaultLayout';

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('app');
    if (container) {
        const root = createRoot(container);
        root.render(
            <App />
        );
    }
});
