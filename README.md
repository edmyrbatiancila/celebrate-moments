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
- [x] Dual-role user system (Creator/Celebrant)
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

## � Project Development Status & Timeline

> **SCRUM-Style Progress Tracking**  
> This section documents the development journey, current sprint status, and upcoming milestones.

### 🗓️ Development Timeline

| **Sprint** | **Period** | **Focus Area** | **Status** |
|------------|------------|----------------|------------|
| **Sprint 0** | Oct 13, 2025 | Project Setup & Architecture | ✅ **COMPLETED** |
| **Sprint 1** | Oct 13, 2025 | Core Models & Database Design | ✅ **COMPLETED** |
| **Sprint 2** | Oct 13, 2025 | Template & Media System | ✅ **COMPLETED** |
| **Sprint 3** | Oct 14, 2025 | Model Completion & Relationships | ✅ **COMPLETED** |
| **Sprint 4** | Oct 14, 2025 | Complete API Development | ✅ **COMPLETED** |
| **Sprint 5** | Current | API Testing & Optimization | � **IN PROGRESS** |
| **Sprint 6** | Upcoming | Frontend Development | 📋 **PLANNED** |

### 🎯 Current Sprint Status (Sprint 5)

**Sprint Goal:** Comprehensive API testing and optimization for production readiness

**Progress:** 85% Complete

#### ✅ **DONE** (Completed Features)
- **User Management System**
  - ✅ Dual-role user system (Creator/Celebrant)
  - ✅ User authentication with Laravel Fortify
  - ✅ Role switching functionality
  - ✅ User factory with multiple states (creator/celebrant/verified)
  - ✅ Comprehensive user seeding (18 users total)

- **Creator Profile System**
  - ✅ Full CreatorProfile model with relationships
  - ✅ Repository pattern implementation
  - ✅ Service layer with business logic
  - ✅ Policy-based authorization
  - ✅ Profile verification system
  - ✅ Factory with verified/premium states

- **Template Management**
  - ✅ Template model with JSON content structure
  - ✅ Category-based organization (birthday, anniversary, holiday, etc.)
  - ✅ Premium/Free template system
  - ✅ Creator-specific templates
  - ✅ Factory with realistic content generation
  - ✅ Comprehensive seeding (35 templates total)

- **Media Management**
  - ✅ Multi-media support (image, video, audio, document)
  - ✅ File metadata tracking
  - ✅ Media-Greeting pivot relationship
  - ✅ Factory with realistic file generation
  - ✅ Comprehensive seeding (varies by user type)

- **Greeting System**
  - ✅ Core greeting functionality
  - ✅ Multi-recipient support
  - ✅ Template integration
  - ✅ Status management (draft, sent, delivered, viewed)
  - ✅ Content data and theme settings
  - ✅ Factory with template relationships

- **Analytics System**
  - ✅ Comprehensive analytics tracking
  - ✅ Engagement metrics (views, shares, likes)
  - ✅ Status-based analytics generation
  - ✅ Rich engagement data structure
  - ✅ Factory with multiple states (popular, viral, low-engagement)

- **Complete API Ecosystem**
  - ✅ AuthController - Authentication, registration, role switching
  - ✅ UserController - User profile management, CRUD operations
  - ✅ GreetingController - Greeting creation, sending, management
  - ✅ TemplateController - Template browsing, filtering, recommendations
  - ✅ MediaController - File upload, media management, storage
  - ✅ CreatorProfileController - Creator profiles, verification, stats
  - ✅ ConnectionController - Social networking, friend requests
  - ✅ ReviewController - Creator reviews, ratings, feedback system
  - ✅ AnalyticsController - Dashboard analytics, platform insights

- **Advanced Backend Features**
  - ✅ Repository pattern for all major models
  - ✅ Service layer architecture
  - ✅ Comprehensive policy system (CreatorProfile, Greeting)
  - ✅ Advanced filtering and pagination
  - ✅ File upload with validation
  - ✅ Social networking features
  - ✅ Rating and review system
  - ✅ Analytics and reporting
  - ✅ 91 API routes registered and functional

#### 🔄 **IN PROGRESS** (Current Work)
- **API Testing & Quality Assurance**
  - � Comprehensive endpoint testing (authentication issues resolved)
  - 🔄 Error handling validation
  - � Performance optimization
  - � Security testing
  - 🔄 API documentation finalization

#### 📋 **TODO** (Next Sprint Items)
- **Frontend Development**
  - 📋 React component architecture setup
  - 📋 Authentication interface implementation
  - 📋 Creator dashboard development
  - 📋 Celebrant interface creation
  - 📋 Greeting creation workflow
  - 📋 Media upload interface

### 📊 Technical Achievements

**Database Architecture:**
- ✅ 17 migration files successfully implemented
- ✅ Complex foreign key relationships established
- ✅ Pivot tables for many-to-many relationships
- ✅ JSON column support for flexible data structures
- ✅ Soft deletes and cascade delete strategies

**Backend Implementation:**
- ✅ 58 greetings generated with realistic data
- ✅ Media library with 400+ files across all types
- ✅ Template system with 35 diverse templates
- ✅ Analytics tracking for all greetings
- ✅ Repository pattern with interface contracts
- ✅ Factory pattern for comprehensive testing data

**Code Quality & Patterns:**
- ✅ Repository pattern implementation
- ✅ Service layer architecture
- ✅ Policy-based authorization
- ✅ Factory states for varied test data
- ✅ Comprehensive data seeding
- ✅ Interface segregation principle

### 🚧 Current Challenges & Blockers

#### � **Medium Priority Issues**
1. **API Authentication Optimization**
   - **Issue:** Laravel Sanctum token management optimization needed
   - **Status:** Basic authentication working, optimization in progress
   - **Next Action:** Implement token refresh and session management

2. **Performance Optimization**
   - **Challenge:** Database query optimization for complex relationships
   - **Consideration:** Implement caching strategy and query optimization
   
3. **Frontend Architecture Decision**
   - **Challenge:** React component organization for dual-role UI
   - **Consideration:** Shared components vs role-specific components

#### ✅ **RESOLVED** (Previously High Priority)
1. **Model Relationship Completion** ✅
   - **Resolution:** All models completed with full relationships and helper methods
   - **Achievement:** Connection, Review, Wishlist, Collaboration models fully implemented

2. **API Controller Architecture** ✅
   - **Resolution:** Complete API ecosystem with 91 endpoints
   - **Achievement:** All controllers implemented with repository pattern and service layers

3. **Authorization System** ✅
   - **Resolution:** Comprehensive policy system implemented
   - **Achievement:** CreatorProfile and Greeting policies with proper authorization logic

### 🎯 Next Sprint Objectives (Sprint 6)

**Primary Goals:**
1. 🚀 Complete frontend architecture setup
2. 🎨 Implement authentication interface with role switching
3. � Create responsive dashboard layouts (Creator/Celebrant)
4. � Build greeting creation workflow interface
5. 📊 Integrate analytics dashboard with charts

**Success Criteria:**
- Complete React component architecture
- Functional authentication flow with role switching
- Responsive design across all devices
- Creator and Celebrant dashboards operational
- Media upload interface working
- API integration fully functional

### 🏆 Key Accomplishments

1. **Innovative Dual-Role Architecture:** Successfully implemented a unique system where users can be both creators and celebrants
2. **Scalable Database Design:** Created a flexible, normalized database structure supporting complex greeting relationships
3. **Rich Content System:** Built comprehensive template and media management with JSON-based content structures
4. **Analytics Foundation:** Implemented detailed analytics tracking for future dashboard development
5. **Factory Pattern Excellence:** Created realistic test data generation with multiple states and relationships
6. **Complete API Ecosystem:** Successfully implemented 91 API endpoints with full CRUD operations across all major features
7. **Advanced Architecture Patterns:** Implemented repository pattern, service layers, and comprehensive authorization system
8. **Social Networking Features:** Built complete connection system with friend requests, reviews, and collaboration tools

### 📈 Development Velocity

- **Total Development Time:** ~16 hours (2-day intensive sprint)
- **Models Completed:** 12 major models with full relationships
- **Database Tables:** 17 tables with complex relationships
- **API Controllers:** 8 comprehensive controllers
- **API Endpoints:** 91 functional routes
- **Factory Classes:** 10+ comprehensive factories with states
- **Seeder Classes:** 10+ seeders with realistic data generation
- **Repository Classes:** 6 repository implementations
- **Service Classes:** 6 service layer implementations
- **Policy Classes:** 2 comprehensive authorization policies
- **Lines of Code:** ~5,000+ lines of backend logic

### 🔮 Future Roadmap

**Phase 1:** Frontend Development (Sprint 6-8) - 🔄 **CURRENT FOCUS**
**Phase 2:** Advanced Features & Optimization (Sprint 9-10)  
**Phase 3:** Mobile App Development (Sprint 11-12)
**Phase 4:** Production Deployment & Scaling (Sprint 13-14)

---

## �📄 License

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