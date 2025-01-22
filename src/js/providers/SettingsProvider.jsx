import React, { createContext, useContext, useState, useMemo, useCallback } from 'react';

const SettingsContext = createContext();

export const SettingsProvider = ({ initialSettings, children }) => {
    const [settings, setSettings] = useState(initialSettings || {});

    const updateSetting = useCallback((key, value) => {
        setSettings((prevSettings) => ({
            ...prevSettings,
            [key]: value,
        }));
    }, []);

    const resetSetting = useCallback((key) => {
        setSettings((prevSettings) => ({
            ...prevSettings,
            [key]: initialSettings[key],
        }));
    }, [initialSettings]);

    const resetAllSettings = useCallback(() => {
        setSettings(initialSettings);
    }, [initialSettings]);

    const contextValue = useMemo(
        () => ({
            settings,
            updateSetting,
            resetSetting,
            resetAllSettings,
        }),
        [settings, updateSetting, resetSetting, resetAllSettings]
    );

    return (
        <SettingsContext.Provider value={contextValue}>
            {children}
        </SettingsContext.Provider>
    );
};

export const useSettings = () => {
    const context = useContext(SettingsContext);
    if (!context) {
        throw new Error('useSettings must be used within a SettingsProvider');
    }
    return context;
};

export const useSetting = (key) => {
    const { settings, updateSetting, resetSetting } = useSettings();

    return {
        value: settings[key],
        update: (value) => updateSetting(key, value),
        reset: () => resetSetting(key),
    };
};
