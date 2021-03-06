# Post & Taxonomy Select Controls

Elementor is WordPress page builder plugin which allows making of custom elements and controls
that are used to customize those elements.
These controls allow selection of any post type or taxonomy by fetching them from
database.

Example usage would be selecting posts (blog posts, products, or any other registered type)
that are to be shown on front end inside of a slider, grid, etc. Same goes for taxonomies as
a broader selection tool, allows selecting categories, tags, etc.

Uses ajax to fetch specified post types / taxonomies (declared in `args` parameter when
adding control to element).
Backend functions fetch posts / taxonomies from database using WordPress' native `WP_Query()` 
and `get_terms()` which are very flexible, customizable and accurate.

Since dropdown uses select2.js library response is structured as per their specification.
Planned addition is to allow grouping of posts inside of dropdown view by their category,
as defined in their documentation ([link](https://select2.org/options#dropdown-option-groups)).

## File info:

### elementor.php

Requires necessary files and registers new controls upon Elementor load.
Also contains functions that respond to JS requests for posts and taxonomies.

### class-post-select.php

Defines post selection control and how it's rendered.

### post-select.js

Defines post select handlers: sending ajax request, saving of data etc.

### class-taxonomy-select.php

Defines taxonomy selection control and how it's rendered.
Almost identical to post select control but uses different ajax response function
in the backend tailored to taxonomy query arguments.

### taxonomy-select.js

Defines taxonomy select handlers: sending ajax request, saving of data etc.

### select2.css

Overrides Elementor's `max-height` value for select2 dropdown.

## Setup

- Create `elementor` folder inside of your theme folder and move this files.
- Require or move contents of `elementor.php` inside `functions.php`.
- Add control to desired element
