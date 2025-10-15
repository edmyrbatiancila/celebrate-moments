import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle, PartyPopper, Palette, Crown, Sparkles, CheckCircle } from 'lucide-react';
import { motion } from 'framer-motion';
import { useState } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import AuthLayout from '@/layouts/auth-layout';

export default function Register() {
    const [isCreator, setIsCreator] = useState(false);

    const creatorBenefits = [
        'Earn money from your creative talents',
        'Build your personal brand',
        'Connect with thousands of celebrants',
        'Access premium templates and tools',
        'Analytics and performance insights',
        'Flexible work from anywhere'
    ];

    return (
        <AuthLayout
            title="Join Celebrate Moments"
            description="Create your account and start your journey with us"
        >
            <Head title="Register" />
            
            <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6 }}
                className="space-y-8"
            >
                {/* Role Selection Cards */}
                <div className="grid md:grid-cols-2 gap-4 mb-8">
                    <motion.div
                        whileHover={{ scale: 1.02 }}
                        whileTap={{ scale: 0.98 }}
                        className="cursor-pointer"
                        onClick={() => setIsCreator(false)}
                    >
                        <Card className={`transition-all duration-300 ${!isCreator ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300'}`}>
                            <CardHeader className="text-center pb-4">
                                <motion.div
                                    className="flex justify-center mb-3"
                                    animate={{ scale: !isCreator ? [1, 1.1, 1] : 1 }}
                                    transition={{ duration: 2, repeat: !isCreator ? Infinity : 0 }}
                                >
                                    <div className={`p-3 rounded-full ${!isCreator ? 'bg-blue-500' : 'bg-gray-400'} shadow-lg`}>
                                        <PartyPopper className="w-6 h-6 text-white" />
                                    </div>
                                </motion.div>
                                <CardTitle className="text-lg">I'm Celebrating</CardTitle>
                                <CardDescription className="text-sm">
                                    Order personalized greetings for special moments
                                </CardDescription>
                            </CardHeader>
                        </Card>
                    </motion.div>

                    <motion.div
                        whileHover={{ scale: 1.02 }}
                        whileTap={{ scale: 0.98 }}
                        className="cursor-pointer"
                        onClick={() => setIsCreator(true)}
                    >
                        <Card className={`transition-all duration-300 ${isCreator ? 'border-purple-500 bg-purple-50 shadow-lg' : 'border-gray-200 hover:border-purple-300'}`}>
                            <CardHeader className="text-center pb-4">
                                <motion.div
                                    className="flex justify-center mb-3"
                                    animate={{ rotate: isCreator ? [0, 10, -10, 0] : 0 }}
                                    transition={{ duration: 3, repeat: isCreator ? Infinity : 0 }}
                                >
                                    <div className={`p-3 rounded-full ${isCreator ? 'bg-purple-500' : 'bg-gray-400'} shadow-lg`}>
                                        <Palette className="w-6 h-6 text-white" />
                                    </div>
                                </motion.div>
                                <CardTitle className="text-lg">I'm a Creator</CardTitle>
                                <CardDescription className="text-sm">
                                    Turn your creativity into income
                                </CardDescription>
                                {isCreator && (
                                    <motion.div
                                        initial={{ opacity: 0, scale: 0 }}
                                        animate={{ opacity: 1, scale: 1 }}
                                        className="mt-2"
                                    >
                                        <Badge className="bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                                            <Crown className="w-3 h-3 mr-1" />
                                            Creator Account
                                        </Badge>
                                    </motion.div>
                                )}
                            </CardHeader>
                        </Card>
                    </motion.div>
                </div>

                {/* Creator Benefits - Show only when creator is selected */}
                {isCreator && (
                    <motion.div
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: 'auto' }}
                        exit={{ opacity: 0, height: 0 }}
                        transition={{ duration: 0.5 }}
                        className="mb-6"
                    >
                        <Card className="bg-gradient-to-br from-purple-50 to-pink-50 border-purple-200">
                            <CardHeader className="pb-4">
                                <CardTitle className="text-lg flex items-center gap-2">
                                    <Sparkles className="w-5 h-5 text-purple-600" />
                                    Creator Benefits
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="grid md:grid-cols-2 gap-3">
                                    {creatorBenefits.map((benefit, index) => (
                                        <motion.div
                                            key={index}
                                            initial={{ opacity: 0, x: -20 }}
                                            animate={{ opacity: 1, x: 0 }}
                                            transition={{ duration: 0.3, delay: index * 0.1 }}
                                            className="flex items-center gap-2"
                                        >
                                            <CheckCircle className="w-4 h-4 text-green-500 flex-shrink-0" />
                                            <span className="text-sm text-gray-700">{benefit}</span>
                                        </motion.div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>
                    </motion.div>
                )}

                <Form
                    {...RegisteredUserController.store.form()}
                    resetOnSuccess={['password', 'password_confirmation']}
                    disableWhileProcessing
                    className="flex flex-col gap-6"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-6">
                                {/* Hidden field for creator status */}
                                <input type="hidden" name="is_creator" value={isCreator ? '1' : '0'} />
                                
                                <div className="grid gap-2">
                                    <Label htmlFor="name">
                                        Full Name {isCreator && <span className="text-purple-600">(Creator)</span>}
                                    </Label>
                                    <Input
                                        id="name"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="name"
                                        name="name"
                                        placeholder={isCreator ? "Your creator name" : "Your full name"}
                                        className={isCreator ? "border-purple-300 focus:border-purple-500" : ""}
                                    />
                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email Address</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        required
                                        tabIndex={2}
                                        autoComplete="email"
                                        name="email"
                                        placeholder="email@example.com"
                                        className={isCreator ? "border-purple-300 focus:border-purple-500" : ""}
                                    />
                                    <InputError message={errors.email} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="date_of_birth">Date of Birth</Label>
                                    <Input
                                        id="date_of_birth"
                                        type="date"
                                        required
                                        tabIndex={3}
                                        name="date_of_birth"
                                        className={isCreator ? "border-purple-300 focus:border-purple-500" : ""}
                                    />
                                    <InputError message={errors.date_of_birth} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="password">Password</Label>
                                    <Input
                                        id="password"
                                        type="password"
                                        required
                                        tabIndex={4}
                                        autoComplete="new-password"
                                        name="password"
                                        placeholder="Password"
                                        className={isCreator ? "border-purple-300 focus:border-purple-500" : ""}
                                    />
                                    <InputError message={errors.password} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="password_confirmation">
                                        Confirm Password
                                    </Label>
                                    <Input
                                        id="password_confirmation"
                                        type="password"
                                        required
                                        tabIndex={5}
                                        autoComplete="new-password"
                                        name="password_confirmation"
                                        placeholder="Confirm password"
                                        className={isCreator ? "border-purple-300 focus:border-purple-500" : ""}
                                    />
                                    <InputError
                                        message={errors.password_confirmation}
                                    />
                                </div>

                                <motion.div
                                    whileHover={{ scale: 1.01 }}
                                    whileTap={{ scale: 0.99 }}
                                >
                                    <Button
                                        type="submit"
                                        className={`mt-2 w-full ${
                                            isCreator 
                                                ? "bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600" 
                                                : "bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600"
                                        }`}
                                        tabIndex={6}
                                        data-test="register-user-button"
                                    >
                                        {processing && (
                                            <LoaderCircle className="h-4 w-4 animate-spin mr-2" />
                                        )}
                                        {isCreator ? (
                                            <>
                                                <Crown className="w-4 h-4 mr-2" />
                                                Start Creating & Earning
                                            </>
                                        ) : (
                                            <>
                                                <PartyPopper className="w-4 h-4 mr-2" />
                                                Start Celebrating
                                            </>
                                        )}
                                    </Button>
                                </motion.div>
                            </div>

                            <div className="text-center text-sm text-muted-foreground">
                                Already have an account?{' '}
                                <TextLink href={login()} tabIndex={7}>
                                    Log in
                                </TextLink>
                            </div>

                            {isCreator && (
                                <motion.div
                                    initial={{ opacity: 0 }}
                                    animate={{ opacity: 1 }}
                                    className="text-center text-xs text-gray-500 bg-purple-50 p-3 rounded-lg border border-purple-200"
                                >
                                    <p>
                                        🎉 <strong>Creator Account:</strong> After registration, you'll be guided through our creator onboarding process and subscription plans.
                                    </p>
                                </motion.div>
                            )}
                        </>
                    )}
                </Form>
            </motion.div>
        </AuthLayout>
    );
}
