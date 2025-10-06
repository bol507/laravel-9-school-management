/**
* Create a generic handler for a custom select in Alpine.js
*
* @param {string} name - Name of the select (e.g., 'gender', 'role')
* @param {any} initialSelected - Initial value
* @returns {Object} Object with properties and methods for Alpine
*/
export default function createSelect(name, initialSelected = null) {
    const state = {
        // Estate
        [`selected${name}`]: initialSelected,
        [`open${name}`]: false,
        [`${name}Options`]: [],

        // Metods
        [`init${name}Options`](options) {
            this[`${name}Options`] = Array.isArray(options) ? options : [];
        },

        [`select${name}`](value) {
            this[`selected${name}`] = value;
            this[`open${name}`] = false;
            // Opcional: this.$dispatch(`${name}-selected`, value);
        },

        [`clear${name}`]() {
            this[`selected${name}`] = null;
            this[`open${name}`] = false;
        },

        // Accesor for text to show (x-text)
        [`get${name}Text`](placeholder = 'Select...') {
            const selected = this[`selected${name}`];
            if (selected == null) return placeholder;

            const options = this[`${name}Options`];

            const option = options.find(opt =>
                typeof opt === 'object' && opt !== null && 'value' in opt
                    ? opt.value === selected
                    : opt === selected
            );

            if (option && typeof option === 'object' && 'label' in option) {
                return option.label;
            }


            return selected;
        },

        [`get${name}Value`]() {
            const value = this[`selected${name}`];
            return value !== null && value !== undefined && value !== '' ? value : null;
        },
    };

    return state;
}
