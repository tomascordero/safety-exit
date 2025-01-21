import '../css/frontend.css';
import { useSettings } from './providers/SettingsProvider';
import React from 'react';

export default function LiveView() {
    const { settings, updateSetting } = useSettings();

    console.log(settings);

    return (
        <div className="live-view">
            <div className="browser-chrome">
                <div className="red"></div>
                <div className="yellow"></div>
                <div className="green"></div>
            </div>
            <button
                id="sftExt-frontend-button"
                className={[
                    settings.sftExt_position,
                    settings.sftExt_type,
                ].join(' ')}
            >Safety Exit</button>
        </div>
    );
}
