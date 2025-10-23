# Coding Conventions and Standards

## PHP Coding Standards

### General Guidelines
- Follow WordPress Coding Standards
- Adhere to PHPCS configuration in `phpcs.xml`
- Use meaningful variable and function names
- Write self-documenting code
- Keep functions focused and single-purpose

### Naming Conventions
- Classes: PascalCase (e.g., `Prayer_Global_Porch`)
- Functions: snake_case (e.g., `get_prayer_coverage`)
- Variables: snake_case (e.g., `$prayer_count`)
- Constants: UPPER_SNAKE_CASE (e.g., `PG_TOTAL_STATES`)
- Namespace: `pg_` prefix for all functions and classes

### File Organization
- One class per file
- Class files in `classes/` directory
- Template files in `templates/` directory
- Include files in `includes/` directory

### WordPress Integration
- Use WordPress hooks and filters
- Follow WordPress plugin structure
- Implement proper security checks
- Use WordPress functions when available

## JavaScript/TypeScript Standards

### General Guidelines
- Use TypeScript for type safety
- Follow ESLint configuration
- Write modular, reusable code
- Implement proper error handling

### Naming Conventions
- Components: PascalCase (e.g., `PrayerMap`)
- Functions: camelCase (e.g., `getPrayerData`)
- Variables: camelCase (e.g., `prayerCount`)
- Constants: UPPER_SNAKE_CASE
- Interfaces: PascalCase with 'I' prefix (e.g., `IPrayerData`)

### File Organization
- One component per file
- Shared utilities in `utils/`
- Types in `types/`
- Components in `components/`

### React Guidelines
- Use functional components
- Implement proper prop types
- Follow React best practices
- Use hooks appropriately

## Database Conventions

### Table Naming
- Prefix tables with `pg_`
- Use snake_case for table names
- Use plural form for table names

### Column Naming
- Use snake_case for column names
- Include table prefix in foreign keys
- Use descriptive names

### Indexing
- Index foreign keys
- Index frequently queried columns
- Use appropriate index types

## API Conventions

### Endpoint Structure
- Use RESTful naming
- Version endpoints appropriately
- Use proper HTTP methods
- Return consistent response formats

### Response Format
```json
{
    "success": true,
    "data": {},
    "message": "Optional message"
}
```

### Error Handling
- Use appropriate HTTP status codes
- Include detailed error messages
- Log errors appropriately
- Handle edge cases

## Documentation Standards

### Code Documentation
- Document all public methods
- Include parameter descriptions
- Document return values
- Add usage examples where needed

### File Headers
```php
/**
 * File Description
 *
 * @package Prayer_Global
 * @subpackage Component
 * @since 1.0.0
 */
```

### Inline Comments
- Explain complex logic
- Document workarounds
- Note potential issues
- Reference related code

## Version Control

### Branch Naming
- feature/feature-name
- bugfix/bug-description
- hotfix/issue-description
- release/version-number

### Commit Messages
- Use present tense
- Start with verb
- Keep first line under 50 chars
- Add detailed description if needed

### Pull Requests
- Include description
- Reference related issues
- Add testing notes
- Update documentation 