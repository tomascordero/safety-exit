import { Button, TextControl, SelectControl, Popover } from '@wordpress/components';
import IconPicker from './components/IconPicker';

export default function ControlPanel() {
    return (
        <div>
            <h2>Control Panel</h2>
            <SelectControl
                label="Button position"
                onChange={() => {}}
                options={[
                    {
                        disabled: true,
                        label: 'Select an Option',
                        value: ''
                    },
                    {
                        label: 'Bottom Left',
                        value: 'bottom-left'
                    },
                    {
                        label: 'Bottom Right',
                        value: 'bottom-right'
                    }
                ]}
                value="bottom-left"
            />
            <button >
                Choose Icon
                <Popover
                    offset={10}
                    placement="right-start"
                    onClose={() => {}}
                    onFocusOutside={() => {}}
                    >
                    <IconPicker />
                </Popover>
            </button>
        </div>
    );
}
