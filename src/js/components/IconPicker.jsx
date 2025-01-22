import { Icon } from '@wordpress/components';
import { useEffect, useState } from 'react';

export default function IconPicker() {
    const [icons, setIcons] = useState([]);
    console.log('iconpicker')

    useEffect(() => {
        // let [list, chunkSize] = [window.SafetyExitSettings?.icons || [], 5];
        // list = [...Array(Math.ceil(list.length / chunkSize))].map(_ => list.splice(0, chunkSize));
        let list = window.SafetyExitSettings?.icons || [];
        setIcons(list);
    }, []);

    return (
        <div className="sftExt-icon-picker">
            {icons.map((icon, index) => (
                <button key={index} className="sftExt-icon-picker-button">
                    <Icon
                        key={index}
                        icon={( {size} ) => (
                            <img
                                src={icon}
                                style={{ width: size, height: size }}
                            />
                        )}
                    />
                </button>
            ))}
        </div>
    );
}
