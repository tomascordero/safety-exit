import '../css/admin.css';

import React from 'react';
import ReactDOM from 'react-dom/client';

function App() {
    return (
        <div>
            <h1>Hello, World!</h1>
        </div>
    );
}

const root = ReactDOM.createRoot(document.getElementById('sftExtApp'));

root.render(<App />);
