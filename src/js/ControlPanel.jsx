import { SelectControl, Popover } from '@wordpress/components';
import { useSettings } from './providers/SettingsProvider';
import IconPicker from './components/IconPicker';
import ColorInput from './components/ColorInput';
import React from 'react';

export default function ControlPanel() {
    const { settings, updateSetting } = useSettings();
    const [toggleIconSelector, setToggleIconSelector] = React.useState(false);

    const handleIconChange = () => {
        setToggleIconSelector(!toggleIconSelector);
    }

    const handlePositionChange = (e) => {
        updateSetting('sftExt_position', e);
    }

    const handleBgColorChange = (color) => {
        updateSetting('sftExt_bg_color', color);
    }

    const handleFontColorChange = (color) => {
        updateSetting('sftExt_font_color', color);
    }

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
                        value={settings.sftExt_position}
                    />
                </div>
                <div className="col-span-2">
                    {/* TODO: Need to create a better picker */}
                    <button onClick={handleIconChange}>
                        Choose Icon
                        { toggleIconSelector && <Popover
                            offset={10}
                            placement="right-start"
                            onClose={() => {}}
                            onFocusOutside={() => {}}
                            >
                            <IconPicker />
                        </Popover>}
                    </button>
                </div>
            </div>
            <ColorInput label="Background Color" value={settings.sftExt_bg_color} onChange={handleBgColorChange}/>
            <ColorInput label="Font Color" value={settings.sftExt_font_color} onChange={handleFontColorChange}/>
            {/* btn font color picker */}
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
