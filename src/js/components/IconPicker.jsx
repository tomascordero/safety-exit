import { Icon } from '@wordpress/components';
import React from 'react';
import { BaseControl } from '@wordpress/components';

function IconPicker( { onSelect } ) {
    const [icons, setIcons] = React.useState([]);

    React.useEffect(() => {
        let list = window.SafetyExitSettings?.icons || [];
        setIcons(list);
    }, []);

    const handleSelect = (icon) => {
        onSelect(icon);
    }

    // const iconValue = settings.sftExt_icon_url || settings.sftExt_fontawesome_icon_classes

    return (
        <BaseControl>
            <BaseControl.VisualLabel>
                Button Icon
            </BaseControl.VisualLabel>
            <div className="sftExt-icon-picker">
                {icons.map((icon, index) => (
                    <button key={index} className="sftExt-icon-picker-button" onClick={() => {
                        handleSelect(icon);
                    }}>
                        <Icon
                            key={index}
                            icon={( {size} ) => (
                                <img
                                    src={icon}
                                />
                            )}
                        />
                    </button>
                ))}
            </div>
        </BaseControl>
    );
}

export default React.memo(IconPicker);
