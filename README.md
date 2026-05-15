# Today Morning News — Daily Editorial Engine

![Today Morning News Dashboard](file:///C:/Users/HP/.gemini/antigravity/brain/e9cffec9-dbff-406b-a26a-ae15f7d20d17/chronicle_os_dashboard_mockup_1778884376453.png)

Today Morning News is a high-performance, enterprise-grade news content management system built for modern journalism. Designed with a "Today Morning News" aesthetic, it provides an immersive, full-screen environment for creators and editors.

## 🚀 Key Features

- **Professional Editorial Workflow**: Multi-role system (Journalists, Editors, Admins) with draft management, revision requests, and one-click publishing.
- **Real-Time Breaking News**: Dynamic news ticker and urgent story highlighting.
- **Advanced Analytics**: Real-time engagement tracking with Chart.js visualizations (views, trending topics, device breakdown).
- **Premium UI/UX**: Built with Tailwind CSS and Alpine.js, featuring glassmorphism, smooth animations, and a global dark mode toggle.
- **Performance Optimized**: Database indexing, eager loading, and throttled view tracking for maximum efficiency.
- **Media Management**: Robust image handling with optimization.

## 🛠️ Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Livewire 3, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Visuals**: Chart.js, Lucide Icons, Google Fonts (Outfit)

## 📦 Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/SAURAAVSARKAR/newspaper.git
   cd newspaper-cms
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**: Update `.env` with your database credentials.

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start Development Server**:
   ```bash
   php artisan serve
   npm run dev
   ```

## 🔐 Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@newspaper.com` | `password` |

## 📊 Performance Optimizations

- **N+1 Prevention**: All major components use Eager Loading for relationships.
- **SQL Indexing**: Strategic indexes on `status`, `published_at`, `is_featured`, and `viewed_at`.
- **Analytics aggregation**: Device and hourly statistics are computed directly in SQL.

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
