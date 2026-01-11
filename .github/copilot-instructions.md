# WordPress Development Guide for AI Agents

## Architecture Overview

This is a WordPress installation with SQLite database integration (via drop-in at [wp-content/db.php](../wp-content/db.php)), running locally with:
- Database: SQLite (via `sqlite-database-integration` mu-plugin)
- Local development credentials: `DB_USER=root`, `DB_PASSWORD=root`, `DB_HOST=localhost`
- Custom code lives exclusively in [wp-content/](../wp-content/) - **never modify core WordPress files** in `wp-admin/` or `wp-includes/`

## Custom Development Structure

### Child Themes
Primary active theme: [wp-content/themes/twentytwentyfive-child/](../wp-content/themes/twentytwentyfive-child/)
- Inherits from Twenty Twenty-Five parent theme
- Custom styles enqueued via [functions.php](../wp-content/themes/twentytwentyfive-child/functions.php) with proper dependency on parent theme
- [theme.json](../wp-content/themes/twentytwentyfive-child/theme.json) defines custom font family "Expressway" with multiple weights (200-600) loaded from `assets/fonts/`

### Custom Plugins
All located in [wp-content/plugins/](../wp-content/plugins/):
- **photoset** ([photoset.php](../wp-content/plugins/photoset/photoset.php)): Custom post type plugin for photo galleries
  - Registers `photoset` CPT with Gutenberg support (`show_in_rest: true`)
  - Integrates with Query Loop blocks via `query_loop_include_photoset` parameter
  - Uses `pre_get_posts` filter to conditionally include photosets in query results based on `query-loop-with-photosets` CSS class
- Active third-party: ACF, Jetpack, Gutenberg plugin (trunk version), Photonic, Classic Editor, Page Optimize

### Must-Use Plugins
[wp-content/mu-plugins/](../wp-content/mu-plugins/):
- `sqlite-database-integration/` - Required for SQLite database support

## WordPress-Specific Patterns

### Plugin Development
When creating/modifying plugins in [wp-content/plugins/](../wp-content/plugins/):
1. Always check `ABSPATH` is defined at the top of PHP files (security pattern):
   ```php
   if ( ! defined( 'ABSPATH' ) ) {
       exit;
   }
   ```
2. Use WordPress hooks pattern: `add_action()` and `add_filter()` for all functionality
3. Custom post types: Use `register_post_type()` hooked to `init` action
4. For Gutenberg compatibility: Set `'show_in_rest' => true` in post type args
5. Query modifications: Use `pre_get_posts` action with proper admin/main query checks
6. Block integration: Use `render_block` filter for block-specific modifications

### Theme Development
For child theme work in [wp-content/themes/twentytwentyfive-child/](../wp-content/themes/twentytwentyfive-child/):
1. Enqueue styles with parent dependency: `array('twentytwentyfive')` as third parameter
2. Use `theme.json` for design tokens, colors, typography, and spacing
3. Font declarations use `fontFace` array with proper weight/style definitions
4. Reference fonts via `file:./assets/fonts/` paths in theme.json

### Block Editor / Gutenberg
This site uses block themes (FSE) with Gutenberg plugin active:
- Custom block patterns can be registered via theme or plugin
- Query Loop blocks can be extended with custom post types using CSS class detection
- Template parts and patterns are managed through Site Editor

## Critical Workflows

### Local Development
- Database: SQLite-based (no MySQL/MariaDB needed)
- Configuration in [wp-config.php](../wp-config.php) - credentials already set for local environment
- No build process required for core theme/plugin work

### Plugin Activation
- Simple plugins: Drop in `wp-content/plugins/` folder, activate via WP Admin
- Must-use plugins: Place in `wp-content/mu-plugins/` - auto-loaded, no activation needed

### Debugging
- Enable via [wp-config.php](../wp-config.php): Set `WP_DEBUG` to `true`
- Check `wp-content/debug.log` for PHP errors when debugging is enabled

## File Organization Rules

**NEVER modify:**
- Core WordPress files in [wp-admin/](../wp-admin/), [wp-includes/](../wp-includes/), or root PHP files
- Parent theme files in [wp-content/themes/twentytwentyfive/](../wp-content/themes/twentytwentyfive/)

**ALWAYS work in:**
- Custom plugins: [wp-content/plugins/](../wp-content/plugins/)
- Child theme: [wp-content/themes/twentytwentyfive-child/](../wp-content/themes/twentytwentyfive-child/)
- Must-use plugins: [wp-content/mu-plugins/](../wp-content/mu-plugins/) (for critical functionality)

## WordPress Coding Conventions

- Function naming: Use prefixes to avoid conflicts (e.g., `photoset_register_photo_post_type`)
- Hook priority: Default is 10; specify when order matters (e.g., `add_filter('render_block', 'fn', 10, 2)`)
- Use WordPress functions over PHP equivalents when available (e.g., `wp_enqueue_style()` vs manual `<link>` tags)
- Security: Sanitize input, escape output, use nonces for forms, check capabilities before privileged operations
