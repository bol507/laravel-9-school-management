/**
 * Create a generic handler for a custom select dropdown in Alpine.js.
 *
 * This utility generates a reusable Alpine.js state object for select-like components
 * (e.g., gender, role, designation) that are not native <select> elements,
 * but custom dropdowns built with divs, lists, etc.
 *
 * @param {string} name - The logical name of the select (e.g., 'gender', 'role').
 *                        Used to generate property and method names dynamically.
 * @param {any} initialSelected - The initial selected value (optional, defaults to null).
 * @returns {Object} An object containing reactive state and methods ready to be used in Alpine.js.
 */
export default function createSelect(name, initialSelected = null) {
    const state = {
        // === State properties ===
        [`selected${name}`]: initialSelected,   // Currently selected value
        [`open${name}`]: false,                 // Whether the dropdown is open
        [`${name}Options`]: [],                 // List of available options (strings or { value, label } objects)

        // === Methods ===
        /**
         * Initialize the list of options for this select.
         * @param {Array} options - Array of options. Each can be a primitive (string/number)
         *                          or an object with `value` and optionally `label`.
         */
        [`init${name}Options`](options) {
            this[`${name}Options`] = Array.isArray(options) ? options : [];
        },

        /**
         * Select a value and close the dropdown.
         * @param {any} value - The value to select.
         */
        [`select${name}`](value) {
            this[`selected${name}`] = value;
            this[`open${name}`] = false;
            // Optional: dispatch a custom event for parent components
            // this.$dispatch(`${name}-selected`, value);
        },

        /**
         * Clear the current selection and close the dropdown.
         */
        [`clear${name}`]() {
            this[`selected${name}`] = null;
            this[`open${name}`] = false;
        },

        /**
         * Get the display text for the selected option (used with x-text).
         * @param {string} placeholder - Text to show when nothing is selected.
         * @returns {string} The label or value to display.
         */
        [`get${name}Text`](placeholder = 'Select...') {
            const selected = this[`selected${name}`];
            if (selected == null) return placeholder;

            const options = this[`${name}Options`];

            // Find the matching option
            const option = options.find(opt =>
                typeof opt === 'object' && opt !== null && 'value' in opt
                    ? opt.value === selected
                    : opt === selected
            );

            // If it's an object with a 'label', return the label
            if (option && typeof option === 'object' && 'label' in option) {
                return option.label;
            }

            // Otherwise, return the value itself (for primitive options)
            return selected;
        },

        /**
         * Get the current selected value in a normalized way (null if empty).
         * Useful for form submission or validation.
         * @returns {any|null} The selected value, or null if empty.
         */
        [`get${name}Value`]() {
            const value = this[`selected${name}`];
            return value !== null && value !== undefined && value !== '' ? value : null;
        },
    };

    return state;
}
