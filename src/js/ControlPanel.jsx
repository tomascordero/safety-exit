import { SelectControl } from '@wordpress/components';
import { useSettings, useSetting } from './providers/SettingsProvider';
import IconPicker from './components/IconPicker';
import ColorInput from './components/ColorInput';
import React from 'react';

export default function ControlPanel() {
    // const { settings, updateSetting } = useSettings();
    const bgColorSetting = useSetting('sftExt_bg_color');
    const fontColorSetting = useSetting('sftExt_font_color');
    const positionSetting = useSetting('sftExt_position');

    const handlePositionChange = (e) => {
        positionSetting.update(e);
    }

    const handleBgColorChange = (color) => {
        bgColorSetting.update(color);
    }

    const handleFontColorChange = (color) => {
        fontColorSetting.update(color);
    }

    // const iconValue = settings.sftExt_icon_url || settings.sftExt_fontawesome_icon_classes;

    return (
        <div className="control-panel">
            <h2>Control Panel</h2>
            <div className="sftExt-grid">
                <div className="col-span-2">
                    <SelectControl
                        label="Button position"
                        onChange={handlePositionChange}
                        options={[
                            {
                                disabled: true,
                                label: 'Select an Option',
                                value: ''
                            },
                            {
                                label: 'Bottom Left',
                                value: 'bottom left'
                            },
                            {
                                label: 'Bottom Right',
                                value: 'bottom right'
                            }
                        ]}
                        value={positionSetting.value}
                    />
                </div>
                <div className="col-span-2">
                    {/* <IconInput label="Button Icon" value={iconValue} onChange={console.log} /> */}
                </div>
            </div>
            <IconPicker onSelect={console.log}/>
            <ColorInput label="Background Color" value={bgColorSetting.value} onChange={handleBgColorChange}/>
            <ColorInput label="Font Color" value={fontColorSetting.value} onChange={handleFontColorChange}/>
            {/* btn type (rectangle / circle) */}
            {/* btn text */}
            {/* btn include icon */}
            {/* btn fontsize */}
            {/* btn font units */}
            {/* redirect URL 1 */}
            {/* redirect URL 2 */}
            {/* Hide on mobile toggle */}
            {/* show on all pages toggle */}
            {/* Show on front page toggle */}
            {/* A way to display on specific page */}
        </div>
    );
}
