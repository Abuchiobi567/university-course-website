# University Course Website (PHP + Docker)

A dynamic university website where visitors browse subject areas, search courses and send enquiries, and staff manage everything from an admin area. Built in PHP with a MariaDB database, running in Docker.

## Features

| Area | What it does |
|---|---|
| User accounts | A superadmin adds and deletes staff accounts. The superadmin account is protected from deletion. |
| Subject areas | Staff add, rename and delete subject areas, which appear automatically in the site menu. |
| Courses | Staff add and edit courses and move them between subject areas. Courses show on the public site. |
| Enquiries | Visitors submit enquiries. Staff see pending and responded enquiries, and the system logs who responded. |
| Search | Keyword course search, with a filter for part-time courses. |
| Pagination | Subject area pages show 10 courses at a time with page links. |

The full requirement-by-requirement checklist is in [`docs/requirements-checklist.md`](docs/requirements-checklist.md).

## Technical highlights

- **PHP with PDO** and prepared statements for database access
- **Password hashing** with `password_hash` / `password_verify`
- **Session-based access control** separating public pages from the admin area
- Output escaping with `htmlspecialchars` to protect against XSS
- **Docker Compose** stack: Nginx, PHP, MariaDB and supporting services
- Shared header and footer templates

## Run it locally

Requirements: Docker Desktop.

```bash
docker compose up -d
```

The database schema and sample data are in `websites/default/database.sql`.

Local admin login: username `superadmin`, password `password`. This is for local testing only; change it before deploying anywhere public.
