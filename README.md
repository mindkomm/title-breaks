# Title Breaks

Title Breaks is a WordPress plugin allows you to control how your post titles will break.

By adding the following placeholders to your post titles, you can control which HTML characters will be inserted in the frontend:

- `%-%` – Soft hyphen
- `%%%` – Hard break

The placeholders will only be replaced in the frontend and will be applied everywhere where `the_title` filter is used. This means that the placeholders will also work for menu item labels.

Be aware that if you deactivate this plugin, your post titles will show the placeholders everywhere.
