import { Box, Heading, Text, Input, Button, FormControl, FormLabel, FormErrorMessage } from "@chakra-ui/react";
import { useForm } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";

const ForgotPassword = ({ status }: { status?: string }) => {
    const { data, setData, post, processing, errors } = useForm({ email: '' });

    function submit(e) {
        e.preventDefault();
        post(route('password.email'));
    }

    return (
        <Box maxW="md" mx="auto" mt={10} p={6} borderWidth={1} rounded="md">
            <Heading size="lg" mb={4} color={"#4D4D4F"}>パスワード再設定</Heading>
            <Text mb={4}>
                登録したメールアドレスを入力してください。<br />
                パスワード再設定用リンクを送信します。
            </Text>

            {status && <Text color="green.500" mb={4}>{status}</Text>}

            <form onSubmit={submit}>
                <FormControl isInvalid={!!errors.email}>
                    <FormLabel>メールアドレス</FormLabel>
                    <Input
                        type="email"
                        value={data.email}
                        onChange={e => setData('email', e.target.value)}
                    />
                    <FormErrorMessage>{errors.email}</FormErrorMessage>
                </FormControl>

                <Button
                    mt={4}
                    color="white"
                    bg="green.800"
                    _hover={{ bg: "green.700" }}
                    _disabled={{ bg: "green.300", cursor: "not-allowed" }}
                    borderRadius="md"
                    px={6}
                    h="48px"
                    fontWeight="bold"
                    isLoading={processing}
                    type="submit">
                    リセットリンクを送信
                </Button>
            </form>
        </Box>
    );
}

ForgotPassword.layout = (page: React.ReactNode) => (
    <MainLayout title="パスワードリセット">{page}</MainLayout>
);

export default ForgotPassword;
