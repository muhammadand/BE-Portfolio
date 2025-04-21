# Query Builder Documentation

This document explains how to use the Spatie Query Builder integration in the API Starter Kit.

## Overview

The Query Builder allows clients to:

- Filter resources based on URL query parameters
- Sort resources based on URL query parameters
- Include related resources
- Select specific fields
- Append computed attributes

## Basic Usage

The query builder functionality is integrated with the repository pattern and can be accessed through the API endpoints.

### Example Endpoint

```http
GET /api/v1/users
```

## Filtering

You can filter resources by adding query parameters to your request URL:

```http
GET /api/v1/users?filter[name]=John
```

### Available Filters for Users

The following filters are available for the users endpoint:

| Filter | Description | Example |
|--------|-------------|---------|
| `id` | Filter by exact ID | `?filter[id]=1` |
| `name` | Filter by name (partial match) | `?filter[name]=John` |
| `email` | Filter by email (partial match) | `?filter[email]=example.com` |
| `email_verified_at` | Filter by exact email verification date | `?filter[email_verified_at]=2023-01-01 00:00:00` |
| `created_before` | Filter users created before a date | `?filter[created_before]=2023-01-01` |
| `created_after` | Filter users created after a date | `?filter[created_after]=2023-01-01` |

### Multiple Filters

You can combine multiple filters:

```http
GET /api/v1/users?filter[name]=John&filter[created_after]=2023-01-01
```

## Sorting

You can sort resources by adding a `sort` query parameter:

```http
GET /api/v1/users?sort=name
```

For descending order, prefix the field with a `-`:

```http
GET /api/v1/users?sort=-created_at
```

### Available Sorts for Users

The following sorts are available for the users endpoint:

- `id`
- `name`
- `email`
- `created_at`
- `updated_at`

### Multiple Sorts

You can combine multiple sorts:

```http
GET /api/v1/users?sort=name,-created_at
```

## Pagination

Results are paginated by default. You can control pagination with the following parameters:

```http
GET /api/v1/users?page=2&per_page=10
```

## Combining Features

You can combine filtering, sorting, and pagination:

```http
GET /api/v1/users?filter[name]=John&sort=-created_at&page=1&per_page=10
```

## Implementation Details

### Repository Pattern Integration

The query builder is integrated with the repository pattern through:

1. `QueryableRepositoryInterface` - Extends the base repository interface with query builder methods
2. `QueryableRepository` - Abstract implementation that integrates Spatie Query Builder with the repository pattern
3. Model-specific repositories (e.g., `UserRepository`) - Implement specific filtering, sorting, and including rules

### Adding Query Builder to a New Repository

To add query builder functionality to a new repository:

1. Make your repository interface extend `QueryableRepositoryInterface`
2. Make your repository implementation extend `QueryableRepository`
3. Override the following methods to specify allowed operations:
   - `getAllowedFilters()`
   - `getAllowedSorts()`
   - `getAllowedIncludes()`
   - `getAllowedFields()`
   - `getAllowedAppends()`

### Adding Custom Filters

To add custom filters, update the `getAllowedFilters()` method in your repository:

```php
public function getAllowedFilters(): array
{
    return [
        AllowedFilter::exact('id'),
        'name',
        AllowedFilter::scope('active'),
    ];
}
```

Then add the corresponding scope to your model:

```php
public function scopeActive(Builder $query, bool $active = true): Builder
{
    return $query->where('active', $active);
}
```
