import { ColorPicker, Popover, BaseControl, Button, Flex, FlexItem } from '@wordpress/components';
import { useSetting } from '../providers/SettingsProvider';
import React from 'react';

export default function ColorInput( {value, onChange, label} ) {
    // const { value, update, reset } = useSetting('sftExt_bg_color');
    const [toggleBgColorSelector, setToggleBgColorSelector] = React.useState(false);
    const uuid = Math.random().toString(36).substring(7);

    const handleOpenAction = () => {
        setToggleBgColorSelector(!toggleBgColorSelector);
    }

    const colorChangeHandler = (color) => {
        onChange(color);
    }

    return (
        <BaseControl
            id={`color-input-${uuid}`}
            __nextHasNoMarginBottom
        >
            <BaseControl.VisualLabel>
                {label}
            </BaseControl.VisualLabel>
            <div className="color-indicator">
                <button className="color-card" id={`color-input-${uuid}`} style={{backgroundColor: value}} onClick={handleOpenAction}>
                    <span className="screen-reader-text">Choose Color</span>
                </button>
                <p className="color-text">{value}</p>
            </div>
            { toggleBgColorSelector && <Popover
                offset={10}
                placement="right-start"
                variant="toolbar"
                onFocusOutside={handleOpenAction}
                onKeyDown={(e) => {
                    if (e.key === 'Escape') {
                        handleOpenAction();
                    }
                }}
            >
                <Flex justify="flex-end">
                    <Button
                        iconSize={16}
                        icon={<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.2253 4.81108C5.83477 4.42056 5.20161 4.42056 4.81108 4.81108C4.42056 5.20161 4.42056 5.83477 4.81108 6.2253L10.5858 12L4.81114 17.7747C4.42062 18.1652 4.42062 18.7984 4.81114 19.1889C5.20167 19.5794 5.83483 19.5794 6.22535 19.1889L12 13.4142L17.7747 19.1889C18.1652 19.5794 18.7984 19.5794 19.1889 19.1889C19.5794 18.7984 19.5794 18.1652 19.1889 17.7747L13.4142 12L19.189 6.2253C19.5795 5.83477 19.5795 5.20161 19.189 4.81108C18.7985 4.42056 18.1653 4.42056 17.7748 4.81108L12 10.5858L6.2253 4.81108Z" fill="currentColor" /></svg>}
                        label="Close"
                        onClick={handleOpenAction}
                    />
                </Flex>
                <ColorPicker
                    defaultValue={value}
                    enableAlpha
                    onChange={colorChangeHandler}
                />
            </Popover>}
        </BaseControl>
    );
}
