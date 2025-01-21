// import { Button, TabPanel } from '@wordpress/components';
import ControlPanel from './ControlPanel';
import LiveView from './LiveView';
import React from 'react';

export default function App () {
    const [adminNavHeight, setAdminNavHeight] = React.useState(0);
    const [footerHeight, setFooterHeight] = React.useState(0);

    React.useLayoutEffect(() => {
        const adminNavHeight = document.getElementById('wpadminbar').offsetHeight;
        const footerHeight = document.getElementById('wpfooter').offsetHeight;
        document.getElementById('wpbody-content').style.height = `calc(100vh - ${adminNavHeight}px - ${footerHeight}px)`;
        document.getElementById('wpbody-content').style.paddingBottom = `0px`;
        setAdminNavHeight(adminNavHeight);
        setFooterHeight(footerHeight);
    }, []);

    return (
        <div className="wrap sftExt">
            <h1>Safety Exit Settings</h1>
            <div className="layout">
                <ControlPanel />
                <LiveView />
            </div>
        </div>
    );
}
