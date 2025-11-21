export enum checkMode {
    auto,
    manual
}

export interface IConfiguration {
    roots: string[];
    leaves?: string[];
    padding?: number;
    editable?: boolean;
    editing?: string;
    editableClass?: string;
    checkboxes?: boolean;
    checkMode?: checkMode;
    dragAndDrop?: boolean;
    keyboardNavigation?: boolean;
    disabled?: boolean;
    disabledClass?: string;
    focusClass?: string;
    checkedClass?: string;
    indeterminateClass?: string;
}