import '../css/admin.css';

import React from 'react';
import ReactDOM from 'react-dom/client';

import App from './App';
import { SettingsProvider } from './providers/SettingsProvider';

const root = ReactDOM.createRoot(document.getElementById('sftExtApp'));

const initialSettings = window.SafetyExitSettings?.settings || {};

root.render(
    <SettingsProvider initialSettings={initialSettings}>
        <App />
    </SettingsProvider>
);
