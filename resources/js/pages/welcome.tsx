import { dashboard, login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { useState, useEffect } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { 
    Sparkles, 
    Heart, 
    Star, 
    Gift, 
    PartyPopper, 
    Crown, 
    Zap, 
    Camera, 
    Mic, 
    Video, 
    Users, 
    Trophy,
    Rocket,
    CheckCircle,
    ArrowRight,
    User,
    Palette
} from 'lucide-react';
import Confetti from 'react-confetti';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;
    const [showConfetti, setShowConfetti] = useState(false);
    const [selectedRole, setSelectedRole] = useState<'creator' | 'celebrant' | null>(null);
    const [windowSize, setWindowSize] = useState({ width: 0, height: 0 });

    useEffect(() => {
        const updateWindowSize = () => {
            setWindowSize({
                width: window.innerWidth,
                height: window.innerHeight,
            });
        };

        updateWindowSize();
        window.addEventListener('resize', updateWindowSize);

        setShowConfetti(true);
        const timer = setTimeout(() => setShowConfetti(false), 4000);

        return () => {
            clearTimeout(timer);
            window.removeEventListener('resize', updateWindowSize);
        };
    }, []);

    const handleRoleSelection = (role: 'creator' | 'celebrant') => {
        setSelectedRole(role);
        setShowConfetti(true);
        setTimeout(() => setShowConfetti(false), 2000);
    };

    return (
        <>
            <Head title="Welcome to Celebrate Moments" />

            {/* Confetti Effect */}
            {showConfetti && windowSize.width > 0 && (
                <Confetti
                    width={windowSize.width}
                    height={windowSize.height}
                    recycle={false}
                    numberOfPieces={150}
                    gravity={0.3}
                    colors={['#ff6b6b', '#4ecdc4', '#45b7d1', '#f9ca24', '#f0932b', '#eb4d4b', '#6c5ce7', '#a29bfe']}
                />
            )}

            <div className="min-h-screen flex flex-col bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
                {/* Header */}
                <header className="w-full p-6 lg:p-8">
                    <motion.nav 
                        className="flex items-center justify-between max-w-7xl mx-auto"
                        initial={{ opacity: 0, y: -20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.6 }}
                    >
                        <motion.div 
                            className="flex items-center gap-3"
                            whileHover={{ scale: 1.05 }}
                        >
                            <motion.div
                                animate={{ rotate: 360 }}
                                transition={{ duration: 20, repeat: Infinity, ease: "linear" }}
                            >
                                <PartyPopper className="w-8 h-8 text-purple-600" />
                            </motion.div>
                            <h1 className="text-2xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">
                                Celebrate Moments
                            </h1>
                        </motion.div>

                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                                    <Link
                                        href={dashboard()}
                                        className="inline-flex items-center gap-2 px-6 py-2 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium shadow-lg hover:shadow-xl transition-all duration-300"
                                    >
                                        <Trophy className="w-4 h-4" />
                                        Dashboard
                                    </Link>
                                </motion.div>
                            ) : (
                                <div className="flex items-center gap-3">
                                    <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                                        <Link
                                            href={login()}
                                            className="px-4 py-2 text-gray-700 hover:text-purple-600 transition-colors duration-200 font-medium"
                                        >
                                            Log in
                                        </Link>
                                    </motion.div>
                                </div>
                            )}
                        </div>
                    </motion.nav>
                </header>

                {/* Main Content */}
                <main className="flex-1 flex items-center justify-center p-6 lg:p-8">
                    <div className="w-full max-w-7xl mx-auto">
                        {!selectedRole ? (
                            <div className="text-center space-y-12">
                                <motion.div
                                    initial={{ opacity: 0, y: 30 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    transition={{ duration: 0.8 }}
                                    className="space-y-6"
                                >
                                    <motion.div
                                        className="flex justify-center mb-8"
                                        animate={{ 
                                            scale: [1, 1.05, 1],
                                            rotate: [0, 2, -2, 0]
                                        }}
                                        transition={{ 
                                            duration: 4, 
                                            repeat: Infinity,
                                            ease: "easeInOut"
                                        }}
                                    >
                                        <Sparkles className="w-20 h-20 text-purple-600" />
                                    </motion.div>

                                    <h1 className="text-6xl lg:text-8xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent leading-tight">
                                        Celebrate<br />
                                        <span className="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 bg-clip-text text-transparent">
                                            Moments
                                        </span>
                                    </h1>

                                    <p className="text-xl lg:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                                        Create magical personalized greetings that make every celebration unforgettable ✨
                                    </p>
                                </motion.div>

                                <motion.div
                                    initial={{ opacity: 0, y: 30 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    transition={{ duration: 0.8, delay: 0.2 }}
                                    className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto"
                                >
                                    {/* Creator Card */}
                                    <motion.div
                                        whileHover={{ scale: 1.03, y: -10 }}
                                        whileTap={{ scale: 0.98 }}
                                        className="group cursor-pointer"
                                        onClick={() => handleRoleSelection('creator')}
                                    >
                                        <Card className="relative h-full bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-purple-200 hover:border-purple-400 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
                                            <CardHeader className="text-center space-y-4 pb-6">
                                                <motion.div
                                                    className="flex justify-center"
                                                    animate={{ rotate: [0, 10, -10, 0] }}
                                                    transition={{ duration: 3, repeat: Infinity }}
                                                >
                                                    <div className="p-4 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 shadow-lg">
                                                        <Palette className="w-8 h-8 text-white" />
                                                    </div>
                                                </motion.div>

                                                <CardTitle className="text-3xl font-bold text-gray-800">
                                                    I'm a Creator
                                                </CardTitle>
                                                <CardDescription className="text-lg text-gray-600">
                                                    Turn your creativity into magical moments
                                                </CardDescription>
                                            </CardHeader>

                                            <CardContent className="space-y-6">
                                                <div className="grid grid-cols-2 gap-4">
                                                    <div className="flex items-center gap-2 text-purple-700">
                                                        <Video className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Video Greetings</span>
                                                    </div>
                                                    <div className="flex items-center gap-2 text-purple-700">
                                                        <Mic className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Audio Messages</span>
                                                    </div>
                                                    <div className="flex items-center gap-2 text-purple-700">
                                                        <Camera className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Photo Cards</span>
                                                    </div>
                                                    <div className="flex items-center gap-2 text-purple-700">
                                                        <Zap className="w-5 h-5" />
                                                        <span className="text-sm font-medium">AI Templates</span>
                                                    </div>
                                                </div>

                                                <div className="p-4 bg-white/50 rounded-xl border border-purple-200">
                                                    <p className="text-sm text-gray-700 text-center">
                                                        Join thousands of creators earning from their talent
                                                    </p>
                                                </div>

                                                <motion.div
                                                    className="flex items-center justify-center gap-2 text-purple-600 font-semibold"
                                                    animate={{ x: [0, 5, 0] }}
                                                    transition={{ duration: 2, repeat: Infinity }}
                                                >
                                                    <span>Start Creating</span>
                                                    <ArrowRight className="w-5 h-5" />
                                                </motion.div>
                                            </CardContent>
                                        </Card>
                                    </motion.div>

                                    {/* Celebrant Card */}
                                    <motion.div
                                        whileHover={{ scale: 1.03, y: -10 }}
                                        whileTap={{ scale: 0.98 }}
                                        className="group cursor-pointer"
                                        onClick={() => handleRoleSelection('celebrant')}
                                    >
                                        <Card className="relative h-full bg-gradient-to-br from-blue-50 to-green-50 border-2 border-blue-200 hover:border-blue-400 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
                                            <CardHeader className="text-center space-y-4 pb-6">
                                                <motion.div
                                                    className="flex justify-center"
                                                    animate={{ scale: [1, 1.1, 1] }}
                                                    transition={{ duration: 2, repeat: Infinity }}
                                                >
                                                    <div className="p-4 rounded-full bg-gradient-to-r from-blue-500 to-green-500 shadow-lg">
                                                        <PartyPopper className="w-8 h-8 text-white" />
                                                    </div>
                                                </motion.div>

                                                <CardTitle className="text-3xl font-bold text-gray-800">
                                                    I'm Celebrating
                                                </CardTitle>
                                                <CardDescription className="text-lg text-gray-600">
                                                    Order personalized greetings for special moments
                                                </CardDescription>
                                            </CardHeader>

                                            <CardContent className="space-y-6">
                                                <div className="grid grid-cols-2 gap-4">
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <Gift className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Birthdays</span>
                                                    </div>
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <Heart className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Anniversaries</span>
                                                    </div>
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <Star className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Graduations</span>
                                                    </div>
                                                    <div className="flex items-center gap-2 text-blue-700">
                                                        <Users className="w-5 h-5" />
                                                        <span className="text-sm font-medium">Weddings</span>
                                                    </div>
                                                </div>

                                                <div className="p-4 bg-white/50 rounded-xl border border-blue-200">
                                                    <p className="text-sm text-gray-700 text-center">
                                                        Browse amazing creators and order custom greetings
                                                    </p>
                                                </div>

                                                <motion.div
                                                    className="flex items-center justify-center gap-2 text-blue-600 font-semibold"
                                                    animate={{ x: [0, 5, 0] }}
                                                    transition={{ duration: 2, repeat: Infinity }}
                                                >
                                                    <span>Start Celebrating</span>
                                                    <ArrowRight className="w-5 h-5" />
                                                </motion.div>
                                            </CardContent>
                                        </Card>
                                    </motion.div>
                                </motion.div>
                            </div>
                        ) : selectedRole === 'creator' ? (
                            <motion.div
                                initial={{ opacity: 0, scale: 0.9 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ duration: 0.6 }}
                                className="text-center space-y-12"
                            >
                                <div className="space-y-6">
                                    <motion.div
                                        className="flex justify-center mb-6"
                                        animate={{ rotate: 360 }}
                                        transition={{ duration: 10, repeat: Infinity, ease: "linear" }}
                                    >
                                        <Crown className="w-16 h-16 text-amber-500" />
                                    </motion.div>

                                    <h2 className="text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                        Choose Your Creator Plan
                                    </h2>
                                    <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                                        Start your creative journey and turn your talents into income
                                    </p>

                                    <motion.button
                                        onClick={() => setSelectedRole(null)}
                                        className="text-purple-600 hover:text-purple-700 font-medium underline"
                                        whileHover={{ scale: 1.05 }}
                                    >
                                        ← Back to role selection
                                    </motion.button>
                                </div>

                                <div className="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                                    <Card className="relative h-full border-2 border-gray-200 hover:shadow-xl transition-all duration-500">
                                        <CardHeader className="text-center space-y-4">
                                            <div className="p-3 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg text-white mx-auto w-fit">
                                                <User className="w-6 h-6" />
                                            </div>
                                            <CardTitle className="text-2xl font-bold text-gray-800">Free Creator</CardTitle>
                                            <CardDescription>Start your creative journey</CardDescription>
                                            <div className="text-4xl font-bold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
                                                Free
                                            </div>
                                        </CardHeader>
                                        <CardContent className="space-y-6">
                                            <ul className="space-y-3">
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>3 greetings per month</span>
                                                </li>
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>Basic templates</span>
                                                </li>
                                            </ul>
                                            <Link
                                                href={register()}
                                                className="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg hover:shadow-xl transition-all duration-300"
                                            >
                                                <Rocket className="w-5 h-5" />
                                                Get Started
                                            </Link>
                                        </CardContent>
                                    </Card>

                                    <Card className="relative h-full border-4 border-amber-400 shadow-2xl">
                                        <div className="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                            <Badge className="bg-gradient-to-r from-amber-400 to-orange-500 text-white px-3 py-1 text-sm font-semibold">
                                                Most Popular ���
                                            </Badge>
                                        </div>
                                        <CardHeader className="text-center space-y-4">
                                            <div className="p-3 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 shadow-lg text-white mx-auto w-fit">
                                                <Palette className="w-6 h-6" />
                                            </div>
                                            <CardTitle className="text-2xl font-bold text-gray-800">Basic Creator</CardTitle>
                                            <CardDescription>Level up your creativity</CardDescription>
                                            <div className="text-4xl font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">
                                                $9.99/mo
                                            </div>
                                        </CardHeader>
                                        <CardContent className="space-y-6">
                                            <ul className="space-y-3">
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>25 greetings per month</span>
                                                </li>
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>Premium templates</span>
                                                </li>
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>HD quality exports</span>
                                                </li>
                                            </ul>
                                            <Link
                                                href={register()}
                                                className="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg hover:shadow-xl transition-all duration-300"
                                            >
                                                <Rocket className="w-5 h-5" />
                                                Get Started
                                            </Link>
                                        </CardContent>
                                    </Card>

                                    <Card className="relative h-full border-2 border-gray-200 hover:shadow-xl transition-all duration-500">
                                        <CardHeader className="text-center space-y-4">
                                            <div className="p-3 rounded-full bg-gradient-to-r from-pink-500 to-red-500 shadow-lg text-white mx-auto w-fit">
                                                <Crown className="w-6 h-6" />
                                            </div>
                                            <CardTitle className="text-2xl font-bold text-gray-800">Premium Creator</CardTitle>
                                            <CardDescription>Unlimited creative power</CardDescription>
                                            <div className="text-4xl font-bold bg-gradient-to-r from-pink-500 to-red-500 bg-clip-text text-transparent">
                                                $19.99/mo
                                            </div>
                                        </CardHeader>
                                        <CardContent className="space-y-6">
                                            <ul className="space-y-3">
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>Unlimited greetings</span>
                                                </li>
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>4K quality exports</span>
                                                </li>
                                                <li className="flex items-center gap-3">
                                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                                    <span>Custom branding</span>
                                                </li>
                                            </ul>
                                            <Link
                                                href={register()}
                                                className="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold bg-gradient-to-r from-pink-500 to-red-500 text-white shadow-lg hover:shadow-xl transition-all duration-300"
                                            >
                                                <Rocket className="w-5 h-5" />
                                                Get Started
                                            </Link>
                                        </CardContent>
                                    </Card>
                                </div>
                            </motion.div>
                        ) : (
                            <motion.div
                                initial={{ opacity: 0, scale: 0.9 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ duration: 0.6 }}
                                className="max-w-2xl mx-auto text-center space-y-8"
                            >
                                <motion.div
                                    className="flex justify-center mb-6"
                                    animate={{ 
                                        rotate: [0, 10, -10, 0],
                                        scale: [1, 1.1, 1]
                                    }}
                                    transition={{ duration: 4, repeat: Infinity }}
                                >
                                    <PartyPopper className="w-20 h-20 text-blue-500" />
                                </motion.div>

                                <div className="space-y-4">
                                    <h2 className="text-5xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                                        Ready to Celebrate?
                                    </h2>
                                    <p className="text-xl text-gray-600">
                                        Sign in to browse amazing creators and order personalized greetings
                                    </p>
                                </div>

                                <motion.button
                                    onClick={() => setSelectedRole(null)}
                                    className="text-blue-600 hover:text-blue-700 font-medium underline"
                                    whileHover={{ scale: 1.05 }}
                                >
                                    ← Back to role selection
                                </motion.button>

                                <Card className="p-8 bg-gradient-to-br from-blue-50 to-green-50 border-2 border-blue-200 shadow-xl">
                                    <div className="space-y-6">
                                        <div className="grid grid-cols-2 gap-6">
                                            <div className="flex flex-col items-center gap-3 p-4 bg-white/70 rounded-xl">
                                                <Gift className="w-8 h-8 text-blue-600" />
                                                <div className="text-center">
                                                    <div className="font-semibold text-gray-800">1000+</div>
                                                    <div className="text-sm text-gray-600">Creators</div>
                                                </div>
                                            </div>
                                            <div className="flex flex-col items-center gap-3 p-4 bg-white/70 rounded-xl">
                                                <Star className="w-8 h-8 text-blue-600" />
                                                <div className="text-center">
                                                    <div className="font-semibold text-gray-800">50,000+</div>
                                                    <div className="text-sm text-gray-600">Happy Moments</div>
                                                </div>
                                            </div>
                                        </div>

                                        <Link
                                            href={login()}
                                            className="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-500 to-green-500 text-white font-semibold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300"
                                        >
                                            <PartyPopper className="w-6 h-6" />
                                            Sign In to Start Celebrating
                                            <ArrowRight className="w-6 h-6" />
                                        </Link>

                                        <p className="text-sm text-gray-600 text-center">
                                            Don't have an account? Contact our creators directly to get started!
                                        </p>
                                    </div>
                                </Card>
                            </motion.div>
                        )}
                    </div>
                </main>
            </div>
        </>
    );
}
