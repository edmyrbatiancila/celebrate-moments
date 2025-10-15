import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AuthLayout from '@/layouts/auth-layout';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle, Sparkles, Heart, Star, Gift, PartyPopper } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';
import { useEffect, useState } from 'react';
import Confetti from 'react-confetti';
import AOS from 'aos';
import 'aos/dist/aos.css';

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status, canResetPassword }: LoginProps) {
    const [showConfetti, setShowConfetti] = useState(false);
    const [floatingIcons, setFloatingIcons] = useState<Array<{ id: number; icon: React.ReactNode; x: number; y: number }>>([]);
    const [windowSize, setWindowSize] = useState({ width: 0, height: 0 });

    useEffect(() => {
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-cubic',
        });

        // Set window size for confetti
        const updateWindowSize = () => {
            setWindowSize({
                width: window.innerWidth,
                height: window.innerHeight,
            });
        };

        updateWindowSize();
        window.addEventListener('resize', updateWindowSize);

        // Create floating celebration icons
        const icons = [
            <Sparkles className="w-6 h-6 text-yellow-400" />,
            <Heart className="w-6 h-6 text-pink-400" />,
            <Star className="w-6 h-6 text-blue-400" />,
            <Gift className="w-6 h-6 text-purple-400" />,
            <PartyPopper className="w-6 h-6 text-green-400" />,
        ];

        const generatedIcons = Array.from({ length: 15 }, (_, i) => ({
            id: i,
            icon: icons[Math.floor(Math.random() * icons.length)],
            x: Math.random() * 100,
            y: Math.random() * 100,
        }));

        setFloatingIcons(generatedIcons);

        // Show confetti briefly on load
        setShowConfetti(true);
        const timer = setTimeout(() => setShowConfetti(false), 3000);

        return () => {
            clearTimeout(timer);
            window.removeEventListener('resize', updateWindowSize);
        };
    }, []);

    const containerVariants = {
        hidden: { opacity: 0, y: 50 },
        visible: {
            opacity: 1,
            y: 0,
            transition: {
                duration: 0.8,
                ease: "easeOut",
                staggerChildren: 0.1
            }
        }
    };

    const itemVariants = {
        hidden: { opacity: 0, y: 20 },
        visible: {
            opacity: 1,
            y: 0,
            transition: { duration: 0.6, ease: "easeOut" }
        }
    };

    const floatingVariants = {
        animate: {
            y: [-10, 10, -10],
            rotate: [0, 5, -5, 0],
            transition: {
                duration: 4,
                repeat: Infinity,
                ease: "easeInOut"
            }
        }
    };

    return (
        <>
            <Head title="Welcome Back - Celebrate Moments" />

            {/* Confetti Effect */}
            {showConfetti && windowSize.width > 0 && (
                <Confetti
                    width={windowSize.width}
                    height={windowSize.height}
                    recycle={false}
                    numberOfPieces={100}
                    gravity={0.3}
                    colors={['#ff6b6b', '#4ecdc4', '#45b7d1', '#f9ca24', '#f0932b', '#eb4d4b', '#6c5ce7']}
                />
            )}

            {/* Floating Background Icons */}
            <div className="fixed inset-0 overflow-hidden pointer-events-none z-0">
                {floatingIcons.map((item) => (
                    <motion.div
                        key={item.id}
                        className="absolute opacity-20"
                        style={{
                            left: `${item.x}%`,
                            top: `${item.y}%`,
                        }}
                        variants={floatingVariants}
                        animate="animate"
                        initial={{ opacity: 0 }}
                        whileInView={{ opacity: 0.2 }}
                        transition={{ delay: item.id * 0.2 }}
                    >
                        {item.icon}
                    </motion.div>
                ))}
            </div>

            {/* Gradient Background */}
            <div className="fixed inset-0 bg-gradient-to-br from-purple-400 via-pink-400 to-red-400 opacity-10 z-0" />
            <div className="fixed inset-0 bg-gradient-to-tl from-blue-400 via-indigo-400 to-purple-500 opacity-10 z-0" />

            <div className="relative z-10 min-h-screen flex items-center justify-center p-4">
                <motion.div
                    variants={containerVariants}
                    initial="hidden"
                    animate="visible"
                    className="w-full max-w-md"
                >
                    {status && (
                        <motion.div
                            variants={itemVariants}
                            className="mb-6 p-4 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg backdrop-blur-sm"
                            data-aos="fade-down"
                        >
                            <div className="flex items-center gap-2">
                                <Sparkles className="w-4 h-4" />
                                {status}
                            </div>
                        </motion.div>
                    )}

                    <motion.div variants={itemVariants}>
                        <Card className="backdrop-blur-lg bg-white/80 border-white/20 shadow-2xl shadow-purple-500/20">
                            <CardHeader className="space-y-1 text-center" data-aos="fade-up">
                                <motion.div
                                    className="flex justify-center mb-4"
                                    whileHover={{ scale: 1.1, rotate: 360 }}
                                    transition={{ duration: 0.6, ease: "easeInOut" }}
                                >
                                    <div className="relative">
                                        <PartyPopper className="w-12 h-12 text-purple-600" />
                                        <motion.div
                                            className="absolute -top-2 -right-2"
                                            animate={{
                                                scale: [1, 1.2, 1],
                                                rotate: [0, 180, 360],
                                            }}
                                            transition={{
                                                duration: 2,
                                                repeat: Infinity,
                                                ease: "easeInOut"
                                            }}
                                        >
                                            <Sparkles className="w-4 h-4 text-yellow-500" />
                                        </motion.div>
                                    </div>
                                </motion.div>

                                <CardTitle className="text-3xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">
                                    Welcome Back!
                                </CardTitle>
                                <CardDescription className="text-gray-600">
                                    Ready to create magical moments? ✨
                                </CardDescription>
                            </CardHeader>

                            <CardContent className="space-y-6" data-aos="fade-up" data-aos-delay="200">
                                <Form
                                    {...AuthenticatedSessionController.store.form()}
                                    resetOnSuccess={['password']}
                                    className="space-y-6"
                                >
                                    {({ processing, errors }) => (
                                        <>
                                            <motion.div
                                                variants={itemVariants}
                                                className="space-y-2"
                                                whileHover={{ scale: 1.02 }}
                                                transition={{ duration: 0.2 }}
                                            >
                                                <Label htmlFor="email" className="text-gray-700 font-medium">
                                                    Email Address
                                                </Label>
                                                <div className="relative">
                                                    <Input
                                                        id="email"
                                                        type="email"
                                                        name="email"
                                                        required
                                                        autoFocus
                                                        tabIndex={1}
                                                        className="pl-4 pr-10 py-3 border-2 border-purple-200 focus:border-purple-400 focus:ring-purple-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                        autoComplete="email"
                                                        placeholder="your@email.com"
                                                    />
                                                    <motion.div
                                                        className="absolute right-3 top-3"
                                                        animate={{ rotate: 360 }}
                                                        transition={{ duration: 20, repeat: Infinity, ease: "linear" }}
                                                    >
                                                        <Heart className="w-5 h-5 text-pink-400" />
                                                    </motion.div>
                                                </div>
                                                <AnimatePresence>
                                                    {errors.email && (
                                                        <motion.div
                                                            initial={{ opacity: 0, height: 0 }}
                                                            animate={{ opacity: 1, height: 'auto' }}
                                                            exit={{ opacity: 0, height: 0 }}
                                                            className="text-sm text-red-500 flex items-center gap-1"
                                                        >
                                                            <span>⚠️</span>
                                                            <InputError message={errors.email} />
                                                        </motion.div>
                                                    )}
                                                </AnimatePresence>
                                            </motion.div>

                                            <motion.div
                                                variants={itemVariants}
                                                className="space-y-2"
                                                whileHover={{ scale: 1.02 }}
                                                transition={{ duration: 0.2 }}
                                            >
                                                <div className="flex items-center justify-between">
                                                    <Label htmlFor="password" className="text-gray-700 font-medium">
                                                        Password
                                                    </Label>
                                                    {canResetPassword && (
                                                        <TextLink
                                                            href={request()}
                                                            className="text-sm text-purple-600 hover:text-purple-700 transition-colors duration-200 flex items-center gap-1"
                                                            tabIndex={5}
                                                        >
                                                            <Sparkles className="w-3 h-3" />
                                                            Forgot password?
                                                        </TextLink>
                                                    )}
                                                </div>
                                                <div className="relative">
                                                    <Input
                                                        id="password"
                                                        type="password"
                                                        name="password"
                                                        required
                                                        tabIndex={2}
                                                        className="pl-4 pr-10 py-3 border-2 border-purple-200 focus:border-purple-400 focus:ring-purple-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                        autoComplete="current-password"
                                                        placeholder="Enter your password"
                                                    />
                                                    <motion.div
                                                        className="absolute right-3 top-3"
                                                        animate={{ scale: [1, 1.2, 1] }}
                                                        transition={{ duration: 2, repeat: Infinity }}
                                                    >
                                                        <Star className="w-5 h-5 text-yellow-400" />
                                                    </motion.div>
                                                </div>
                                                <AnimatePresence>
                                                    {errors.password && (
                                                        <motion.div
                                                            initial={{ opacity: 0, height: 0 }}
                                                            animate={{ opacity: 1, height: 'auto' }}
                                                            exit={{ opacity: 0, height: 0 }}
                                                            className="text-sm text-red-500 flex items-center gap-1"
                                                        >
                                                            <span>⚠️</span>
                                                            <InputError message={errors.password} />
                                                        </motion.div>
                                                    )}
                                                </AnimatePresence>
                                            </motion.div>

                                            <motion.div
                                                variants={itemVariants}
                                                className="flex items-center space-x-3"
                                                whileHover={{ scale: 1.02 }}
                                            >
                                                <Checkbox
                                                    id="remember"
                                                    name="remember"
                                                    tabIndex={3}
                                                    className="border-purple-300 text-purple-600"
                                                />
                                                <Label htmlFor="remember" className="text-sm text-gray-600 cursor-pointer">
                                                    Keep me signed in ❤️
                                                </Label>
                                            </motion.div>

                                            <motion.div
                                                variants={itemVariants}
                                                whileHover={{ scale: 1.05 }}
                                                whileTap={{ scale: 0.95 }}
                                            >
                                                <Button
                                                    type="submit"
                                                    className="w-full py-3 bg-gradient-to-r from-purple-500 via-pink-500 to-blue-500 hover:from-purple-600 hover:via-pink-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50"
                                                    tabIndex={4}
                                                    disabled={processing}
                                                    data-test="login-button"
                                                >
                                                    <motion.div
                                                        className="flex items-center justify-center gap-2"
                                                        animate={processing ? { rotate: 360 } : {}}
                                                        transition={{ duration: 1, repeat: processing ? Infinity : 0 }}
                                                    >
                                                        {processing ? (
                                                            <LoaderCircle className="w-5 h-5 animate-spin" />
                                                        ) : (
                                                            <Gift className="w-5 h-5" />
                                                        )}
                                                        {processing ? 'Preparing magic...' : 'Start Celebrating! 🎉'}
                                                    </motion.div>
                                                </Button>
                                            </motion.div>

                                            <motion.div
                                                variants={itemVariants}
                                                className="text-center pt-4 border-t border-purple-100"
                                                data-aos="fade-up"
                                                data-aos-delay="400"
                                            >
                                                <p className="text-sm text-gray-600">
                                                    New to our celebration family?{' '}
                                                    <TextLink
                                                        href={register()}
                                                        className="text-purple-600 hover:text-purple-700 font-semibold transition-colors duration-200 inline-flex items-center gap-1"
                                                        tabIndex={5}
                                                    >
                                                        Join the party! 🎊
                                                        <motion.span
                                                            animate={{ x: [0, 3, 0] }}
                                                            transition={{ duration: 1, repeat: Infinity }}
                                                        >
                                                            →
                                                        </motion.span>
                                                    </TextLink>
                                                </p>
                                            </motion.div>
                                        </>
                                    )}
                                </Form>
                            </CardContent>
                        </Card>
                    </motion.div>

                    {/* Floating Action Bubbles */}
                    <div className="absolute -z-10 inset-0">
                        {[...Array(6)].map((_, i) => (
                            <motion.div
                                key={i}
                                className="absolute w-20 h-20 rounded-full bg-gradient-to-r from-purple-300/30 to-pink-300/30 blur-xl"
                                style={{
                                    left: `${Math.random() * 100}%`,
                                    top: `${Math.random() * 100}%`,
                                }}
                                animate={{
                                    scale: [1, 1.5, 1],
                                    opacity: [0.3, 0.1, 0.3],
                                    x: [0, Math.random() * 50 - 25, 0],
                                    y: [0, Math.random() * 50 - 25, 0],
                                }}
                                transition={{
                                    duration: 4 + Math.random() * 2,
                                    repeat: Infinity,
                                    ease: "easeInOut",
                                    delay: i * 0.5,
                                }}
                            />
                        ))}
                    </div>
                </motion.div>
            </div>
        </>
    );
}
