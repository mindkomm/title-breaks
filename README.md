# Title Breaks

Title Breaks is a WordPress plugin that allows you to control how your post titles will break.

It offers a metabox when you edit a post, where you can enter your post title that should be used when it’s displayed in the frontend. By adding the following placeholders to your display post titles, you can control which HTML characters will be inserted in the frontend:

- `%-%` – Soft hyphen
- `%%%` – Hard break

The placeholders will only be replaced in the frontend and will be applied everywhere where `the_title` filter is used. This means that the placeholders will also work for menu item labels.

If you try to use placeholders in a post title, the plugin will remove them before saving them to the database, because there are some compatibility issues with certain plugins for placeholders in post titles.
