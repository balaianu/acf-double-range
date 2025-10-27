# ACF Double Range Field

The **ACF Double Range Field** extends [Advanced Custom Fields](https://www.advancedcustomfields.com/) by introducing a modern and flexible min–max slider input type. Designed for precision, clarity, and responsiveness, it integrates seamlessly within both the block editor and the classic WordPress experience.

---

## Overview

This plugin provides a clean and intuitive interface for selecting numeric ranges. It combines two synchronized number inputs with a dual-handle slider, offering developers and content editors a more refined way to define numeric intervals.

Key use cases include pricing filters, score ranges, percentage thresholds, or any configuration that requires both a minimum and maximum value.

---

## Features

* Fully compatible with **ACF Free** and **ACF PRO (6.0+)**
* Real-time synchronization between slider and numeric inputs
* Smooth cursor behavior and precision typing
* Configurable limits for `min`, `max`, and `step` values
* Adaptive layout for both block editor and sidebar views
* Lightweight implementation with no external dependencies
* Built on WordPress core’s native **jQuery UI Slider**

---

## Installation

### Using Composer (recommended)

Install the plugin directly from your project’s root directory:

```bash
composer require balaianu/acf-double-range
```

Ensure your environment loads the plugin through the standard WordPress bootstrap or an autoloader.

### Manual Installation

1. Clone or download the repository:

   ```bash
   git clone https://github.com/balaianu/acf-double-range.git
   ```
2. Copy the folder into your `wp-content/plugins/` directory.
3. Activate **ACF Double Range Field** from the WordPress admin under *Plugins → Installed Plugins*.

---

## Usage

Once activated, the new field type will appear in your ACF field type list.

1. In ACF → *Field Groups* → *Add Field*
2. Choose **Field Type → Double Range**
3. Configure the field options:

   * **Minimum Value**: The lower bound of the range.
   * **Maximum Value**: The upper bound of the range.
   * **Step**: The incremental value between range steps.
   * **Default Values**: Optional initial minimum and maximum settings.

The resulting interface presents two numeric inputs alongside a synchronized range slider, enabling direct numeric entry or visual adjustment.

---

## Example

```text
[Min Input]  —  [Slider Track]  —  [Max Input]
```

The component automatically validates all inputs, ensuring values remain within the defined limits. Both values are accessible in your template or logic as an associative array:

```php
$range = get_field('price_range');
$min = $range['min'];
$max = $range['max'];
```

---

## Implementation Notes

* The field is powered by the ACF Field API and integrates with the existing `acf.registerFieldType` JavaScript interface.
* Validation and reactivity are handled in real time using native event listeners.
* CSS is minimal and adaptive, optimized for both editor and sidebar contexts.
* Built entirely using WordPress core assets — no third-party libraries required.

---

## Compatibility

| Environment              | Supported |
| ------------------------ | --------- |
| ACF Free                 | ✓         |
| ACF PRO (6.0+)           | ✓         |
| Classic Editor           | ✓         |
| Block Editor / Gutenberg | ✓         |
| PHP 7.4+                 | ✓         |
| WordPress 5.8+           | ✓         |

---

## Versioning

The plugin follows **Semantic Versioning** principles:

* **2.0.0** — Initial public release (production stable)
* **2.1.x** — Minor enhancements and refinements
* **3.0.0** — Future major updates with expanded configuration options

---

## License

This plugin is open-source software licensed under the **GPLv2 or later** license. You are free to use, modify, and distribute it within the terms of that license.

---

## Contributing

Contributions are welcome. Please submit pull requests or open issues through [GitHub](https://github.com/balaianu/acf-double-range). For significant changes, start a discussion before submitting a PR.

---

**Maintained by [Andrei Balaianu](https://github.com/balaianu)**
