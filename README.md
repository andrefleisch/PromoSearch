# PromoSearch

PromoSearch is a web marketplace that connects local stores offering promotions with customers looking for nearby deals. Stores can create and publish offers, while customers can discover active promotions on a map using their location, a search radius, and product-category filters.

> PromoSearch was developed collaboratively at **Pontifícia Universidade Católica do Paraná (PUCPR)** as a multidisciplinary semester project spanning software development, requirements engineering, databases, and related coursework. The repository represents the team's academic work; it does not assign individual ownership of features because the original Git workflow does not reliably capture individual contributions.

## The problem

Local promotions are often scattered across different channels and difficult to find at the moment they are useful. PromoSearch brings those offers into one place and organizes discovery around the customer's location, while giving stores a simple workflow for publishing and managing promotions.

## User roles

| Role | Main capabilities |
| --- | --- |
| Customer (`Cliente`) | Find nearby stores and active promotions on a map, filter by radius and category, save promotions, manage a profile, and report a store. |
| Store (`Loja`) | Manage a store profile; create, edit, delete, and publish promotions; view the store location on the map. |
| Administrator (`Administrador`) | View dashboard totals, manage users, review reports, resolve them with penalties when applicable, and consult the penalty history. |

## Main features

- Customer and store registration, with role-based sign-in for all three roles
- Profile viewing, editing, and deletion
- Promotion management and publication workflow for stores
- Browser geolocation and map-based discovery of stores with active promotions
- Distance-radius and product-category filters
- Saved promotions for customers
- Email-based password recovery
- Reporting, moderation, and penalty-history workflows

## Technology

- PHP with MySQLi and server-side sessions
- MySQL relational database
- HTML, CSS, and vanilla JavaScript
- Leaflet for the interactive map
- OpenStreetMap data, CARTO map tiles, and Nominatim geocoding
- PHPMailer, managed with Composer, for password-recovery email

## Run locally

### Prerequisites

- PHP 7.0 or newer with the MySQLi extension
- MySQL or MariaDB
- Composer
- An internet connection for the externally hosted map assets and geocoding service

### Setup

1. Clone the repository and enter its directory.

   ```bash
   git clone https://github.com/andrefleisch/PromoSearch.git
   cd PromoSearch
   ```

2. Install the PHP dependency recorded in `composer.lock`.

   ```bash
   composer install
   ```

3. Create the database and tables from the supplied schema.

   ```bash
   mysql -u root -p < "Documentação/Físico.sql"
   ```

4. Configure the database connection. The default local values are `localhost`, port `3307`, user `root`, no password, and database `PromoSearch`. Override them when needed:

   ```bash
   export DB_HOST=127.0.0.1
   export DB_PORT=3306
   export DB_NAME=PromoSearch
   export DB_USER=root
   export DB_PASSWORD='your-local-password'
   ```

5. Start PHP's local development server from the repository root.

   ```bash
   php -S localhost:8000
   ```

6. Open [http://localhost:8000/login.html](http://localhost:8000/login.html). New customer and store accounts can be created through the registration flow. The SQL file creates the schema only; it does not include sample users or promotions.

### Optional: password-recovery email

The rest of the application runs without SMTP configuration. To test password recovery, provide credentials for an SMTP account (for Gmail, use an app password rather than the account password) before starting the server:

```bash
export SMTP_HOST=smtp.gmail.com
export SMTP_PORT=587
export SMTP_USERNAME='your-email@example.com'
export SMTP_PASSWORD='your-app-password'
export APP_URL=http://localhost:8000
```

Never commit real credentials. If a credential has previously been committed, removing it from the latest files is not sufficient: revoke it and consider cleaning the Git history before making the repository public.

## Academic documentation

The original project artifacts are retained in [`Documentação`](./Documenta%C3%A7%C3%A3o), including:

- [Database creation script](./Documenta%C3%A7%C3%A3o/F%C3%ADsico.sql)
- [Conceptual database model](./Documenta%C3%A7%C3%A3o/ModeloConceitualPromoSearch.jpg)
- [Logical database model](./Documenta%C3%A7%C3%A3o/ModeloLogicoPromoSearch.jpeg)
- [Requirements specification](./Documenta%C3%A7%C3%A3o/PromoSearch_Especificacao_Final.docx)
- [Final presentation](./Documenta%C3%A7%C3%A3o/PromoSearch_ApresentacaoFinal.pptx)

## Team

André Gustavo, Babbingtonn Luiz, and Eduardo Michelin.

## License

This repository is available under the [MIT License](./LICENSE).
