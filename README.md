# CelebrateMoments - Special Greeting Event System

![CelebrateMoments Logo](https://via.placeholder.com/600x200/0891b2/ffffff?text=CelebrateMoments)

## 🎉 Overview

CelebrateMoments is a modern, full-stack web application designed to create and deliver personalized greeting experiences through videos, audio messages, and text. The platform features a unique **dual-role system** where users can seamlessly switch between being **Creators** (who design and send greetings) and **Celebrants** (who receive greetings). This innovative approach allows anyone to both give and receive special moments, fostering a community of celebration and connection.

## ✨ Key Features

### 🔧 Creator Features (Admin Role)
- **Multi-Media Greeting Creation**: Upload and manage video, audio, and text greetings
- **Celebrant Management**: Create and manage recipient profiles
- **Customizable Templates**: Pre-designed greeting templates for various occasions
- **Scheduling System**: Schedule greetings for specific dates and times
- **Media Library**: Organize and manage uploaded content
- **Analytics Dashboard**: Track greeting delivery and engagement
- **Preview Mode**: Test greetings before sending
- **Bulk Operations**: Send greetings to multiple recipients
- **Theme Customization**: Personalize greeting appearance and styling
- **Creator Portfolio**: Showcase your greeting creations to attract more celebrants
- **Subscription Management**: Manage premium features and pricing tiers

### 🎁 Celebrant Features (User Role)
- **Interactive Greeting Experience**: Receive multimedia greetings with smooth animations
- **Multiple Greeting Types**: Support for birthdays, anniversaries, holidays, and custom occasions
- **Responsive Design**: Seamless experience across all devices
- **Social Sharing**: Share received greetings on social platforms
- **Greeting History**: View past received greetings
- **Thank You Responses**: Send appreciation messages back to creators
- **Notification System**: Email/SMS notifications for new greetings
- **Personal Profile**: Manage account settings and preferences
- **Creator Discovery**: Browse and connect with greeting creators
- **Wishlist Feature**: Create wishlists for desired greeting types

### 🔄 Dual-Role System Features
- **Role Switching**: Seamlessly switch between Creator and Celebrant modes
- **Account Upgrade**: Transform celebrant accounts into creator accounts
- **Cross-Platform Greeting**: Celebrants can send greetings to other celebrants
- **Community Network**: Build connections within the celebration community
- **Mutual Greeting Exchange**: Create greeting exchange partnerships
- **Creator Verification**: Verification system for professional creators
- **Rating & Reviews**: Rate and review greeting experiences
- **Collaboration Tools**: Multiple creators can collaborate on single greetings
- **Creator Marketplace**: Discover and hire professional greeting creators

### 🎨 Animation & Effects Features
- **Smooth Page Transitions**: Seamless navigation between pages
- **Greeting Reveal Animations**: Exciting unwrapping and reveal effects
- **Particle Effects**: Confetti, stars, and celebration animations
- **Video Transitions**: Smooth video playback with fade effects
- **Interactive Elements**: Hover effects and micro-interactions
- **Loading Animations**: Beautiful loading states and skeleton screens
- **Scroll Animations**: Elements animate as they come into view
- **Gesture Support**: Touch gestures for mobile interactions

## 🛠 Technology Stack

### Backend
- **Framework**: Laravel 12
- **Language**: PHP 8.2+
- **Authentication**: Laravel Fortify
- **Database**: MySQL/PostgreSQL
- **API**: RESTful API with Inertia.js

### Frontend
- **Framework**: React 19
- **Language**: TypeScript 5.7+
- **Styling**: Tailwind CSS 4.0
- **UI Components**: shadcn/ui with Radix UI primitives
- **Bundler**: Vite 7.0+
- **State Management**: React Hooks + Context API

### Recommended Animation Libraries

For those Front-end Developer willing to collaborate with me in this project, I recommend the following animation libraries:

#### 🎬 Primary Animation Libraries
1. **Framer Motion** - For complex animations and gestures
   ```bash
   npm install framer-motion
   ```
   - Perfect for page transitions, greeting reveals, and interactive animations
   - Excellent TypeScript support
   - Built-in gesture recognition

2. **React Spring** - For spring-based animations
   ```bash
   npm install @react-spring/web
   ```
   - Great for smooth, natural-feeling animations
   - Perfect for UI micro-interactions

3. **Lottie React** - For After Effects animations
   ```bash
   npm install lottie-react
   ```
   - Ideal for complex celebration animations and effects

#### 🎨 Additional Animation Tools
4. **React Transition Group** - For component transitions
5. **AOS (Animate On Scroll)** - For scroll-triggered animations
6. **React Confetti** - For celebration particle effects
7. **React Tilt** - For 3D tilt effects on greeting cards

## 📋 System Requirements

### Development Environment
- **Node.js**: 18.x or higher
- **PHP**: 8.2 or higher
- **Composer**: 2.x
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Memory**: 4GB RAM minimum, 8GB recommended
- **Storage**: 2GB free space for development

### Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🚀 Installation & Setup

### Prerequisites
1. Install [Node.js](https://nodejs.org/) (v18+)
2. Install [PHP](https://www.php.net/) (v8.2+)
3. Install [Composer](https://getcomposer.org/)
4. Install [Git](https://git-scm.com/)

### Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/celebrate-moments.git
   cd celebrate-moments
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed
   ```

6. **Start Development Servers**
   ```bash
   # Terminal 1 - Laravel backend
   php artisan serve
   
   # Terminal 2 - Vite frontend
   npm run dev
   ```

7. **Access the application**
   - Frontend: http://localhost:5173
   - Backend API: http://localhost:8000

## ⚙️ Configuration

### Environment Variables
```env
APP_NAME=CelebrateMoments
APP_ENV=local
APP_KEY=your-app-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=celebrate_moments
DB_USERNAME=your-username
DB_PASSWORD=your-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password

FILESYSTEM_DISK=local
```

### Media Storage Configuration
Configure your preferred storage driver for media files:
- Local storage (development)
- AWS S3 (production)
- Digital Ocean Spaces
- Google Cloud Storage

## 📁 Project Structure

```
greeting-event-system/
├── app/                          # Laravel backend
│   ├── Http/Controllers/         # API controllers
│   ├── Models/                   # Eloquent models
│   └── Providers/               # Service providers
├── config/                      # Laravel configuration
├── database/                    # Migrations and seeders
├── resources/                   # Frontend assets
│   ├── js/                     # React TypeScript code
│   │   ├── components/         # Reusable UI components
│   │   ├── pages/             # Page components
│   │   ├── layouts/           # Layout components
│   │   ├── hooks/             # Custom React hooks
│   │   ├── types/             # TypeScript definitions
│   │   └── actions/           # API actions
│   └── css/                   # Tailwind CSS
├── routes/                     # Laravel routes
├── storage/                    # File storage
└── tests/                     # Test files
```

## 🧪 Testing

### Backend Tests (PHP)
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/GreetingTest.php

# Run with coverage
php artisan test --coverage
```

### Frontend Tests (TypeScript)
```bash
# Run component tests
npm run test

# Run tests with coverage
npm run test:coverage

# Run tests in watch mode
npm run test:watch
```

### Linting & Formatting
```bash
# Check code formatting
npm run format:check

# Fix code formatting
npm run format

# Run ESLint
npm run lint

# Type checking
npm run types
```

## 🚀 Deployment

### Production Build
```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

### Server Requirements
- PHP 8.2+ with required extensions
- Node.js 18+ (for build process)
- Web server (Nginx/Apache)
- Database server (MySQL/PostgreSQL)
- SSL certificate (recommended)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards for PHP
- Use TypeScript strict mode
- Write tests for new features
- Update documentation for changes
- Use conventional commit messages

## 📝 API Documentation

### Authentication & User Management
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration
- `POST /api/auth/logout` - User logout
- `GET /api/auth/user` - Get authenticated user
- `POST /api/auth/switch-role` - Switch between Creator and Celebrant roles
- `PUT /api/auth/upgrade-to-creator` - Upgrade celebrant account to creator

### Creator Management
- `GET /api/creators` - List available creators
- `GET /api/creators/{id}` - Get creator profile
- `PUT /api/creators/profile` - Update creator profile
- `POST /api/creators/verify` - Submit creator verification
- `GET /api/creators/analytics` - Get creator analytics

### Greeting Management
- `GET /api/greetings` - List greetings (filtered by role)
- `POST /api/greetings` - Create greeting (creator role required)
- `PUT /api/greetings/{id}` - Update greeting
- `DELETE /api/greetings/{id}` - Delete greeting
- `POST /api/greetings/{id}/send` - Send greeting to celebrant(s)
- `GET /api/greetings/received` - Get received greetings (celebrant view)
- `POST /api/greetings/{id}/thank` - Send thank you response

### Celebrant Interaction
- `GET /api/celebrants/discover` - Discover other celebrants
- `POST /api/celebrants/connect` - Connect with other celebrants
- `GET /api/celebrants/connections` - Get celebrant connections
- `POST /api/celebrants/{id}/greet` - Send greeting to another celebrant

### Media Management
- `POST /api/media/upload` - Upload media files
- `GET /api/media/{id}` - Get media file
- `DELETE /api/media/{id}` - Delete media file
- `GET /api/media/library` - Get user's media library

### Community Features
- `GET /api/marketplace` - Browse creator marketplace
- `POST /api/reviews` - Leave review for creator/greeting
- `GET /api/reviews/{creatorId}` - Get creator reviews
- `POST /api/wishlist` - Add item to wishlist
- `GET /api/wishlist` - Get user's wishlist

## 🎯 Roadmap

### Phase 1 (Current)
- [x] Basic project setup
- [x] Authentication system
- [ ] Dual-role user system (Creator/Celebrant)
- [ ] Creator dashboard
- [ ] Celebrant interface
- [ ] Greeting creation interface
- [ ] Media upload functionality

### Phase 2
- [ ] Role switching functionality
- [ ] Celebrant-to-celebrant greeting system
- [ ] Creator marketplace
- [ ] Advanced animations and effects
- [ ] Email/SMS notifications
- [ ] Social sharing features
- [ ] Creator verification system

### Phase 3
- [ ] Mobile app (React Native)
- [ ] Advanced analytics and insights
- [ ] AI-powered greeting suggestions
- [ ] Multi-language support
- [ ] Collaboration tools for creators
- [ ] Subscription and monetization features
- [ ] Community features and reviews

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel team for the amazing framework
- React team for the powerful frontend library
- shadcn for the beautiful UI components
- Tailwind CSS for the utility-first styling
- All contributors and supporters

## 📞 Support

For support, email support@celebratemoments.app or join our community:
- Discord: [CelebrateMoments Community](https://discord.gg/celebratemoments)
- GitHub Issues: [Report a bug](https://github.com/yourusername/celebrate-moments/issues)
- Documentation: [Full Documentation](https://docs.celebratemoments.app)

---

**Made with ❤️ for creating memorable moments**