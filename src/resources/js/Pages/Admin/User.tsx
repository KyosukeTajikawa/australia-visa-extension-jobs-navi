import React from "react";
import { Box, Heading, Text, Flex, Stack, HStack, Badge, Link, } from "@chakra-ui/react";
import MainLayout from "@/Layouts/MainLayout";

// ------- 型定義 -------

type Farm = {
    id: number;
    name: string;
    created_at: string;
};

type Review = {
    id: number;
    farm_rating: number | null;
    created_at: string;
};

type User = {
    id: number;
    name: string;
    email: string;
    created_at: string;
    farms: Farm[];
    user_reviews: Review[];
};

type UserListProps = {
    users: User[];
};

// ------- コンポーネント本体 -------

const UserList = ({ users }: UserListProps) => {
    return (
        <Box maxW="1200px" mx="auto" py={8} px={{ base: 4, md: 6 }}>
            <Heading mb={6} fontSize={{ base: "2xl", md: "3xl" }} color="gray.700">
                ユーザー一覧
            </Heading>

            <Text mb={4} fontSize="sm" color="gray.600">
                行をクリックすると、そのユーザーの詳細ページ（作成したファーム・レビュー一覧）へ移動します。
            </Text>

            <Box bg="white" borderRadius="lg" boxShadow="sm" overflow="hidden">
                {/* ヘッダー行 */}
                <Flex
                    px={4}
                    py={3}
                    bg="gray.50"
                    borderBottom="1px solid"
                    borderColor="gray.200"
                    fontSize="sm"
                    fontWeight="bold"
                    color="gray.600"
                >
                    <Box flex="2">ユーザー名</Box>
                    <Box flex="3">メールアドレス</Box>
                    <Box flex="1" textAlign="right">
                        ファーム数
                    </Box>
                    <Box flex="1" textAlign="right">
                        レビュー数
                    </Box>
                    <Box flex="1" textAlign="right" display={{ base: "none", md: "block" }}>
                        登録日
                    </Box>
                </Flex>

                {/* ユーザー行 */}
                <Stack spacing={0}>
                    {users.length === 0 && (
                        <Box px={4} py={4}>
                            <Text fontSize="sm" color="gray.500">
                                ユーザーが登録されていません。
                            </Text>
                        </Box>
                    )}

                    {users.map((user) => (
                        <Link
                            key={user.id}
                            href={`/admin/user/${user.id}`}
                            _hover={{ textDecoration: "none" }}
                        >
                            <Flex
                                px={4}
                                py={3}
                                fontSize="sm"
                                align="center"
                                borderTop="1px solid"
                                borderColor="gray.100"
                                _hover={{ bg: "gray.50" }}
                            >
                                {/* ユーザー名 + ID */}
                                <Box flex="2">
                                    <HStack spacing={2}>
                                        <Text fontWeight="medium">{user.name}</Text>
                                        <Badge colorScheme="green">ID: {user.id}</Badge>
                                    </HStack>
                                </Box>

                                {/* メール */}
                                <Box flex="3">
                                    <Text color="gray.700">{user.email}</Text>
                                </Box>

                                {/* ファーム数 */}
                                <Box flex="1" textAlign="right">
                                    <Text>{user.farms?.length ?? 0}</Text>
                                </Box>

                                {/* レビュー数 */}
                                <Box flex="1" textAlign="right">
                                    <Text>{user.user_reviews?.length ?? 0}</Text>
                                </Box>

                                {/* 登録日 */}
                                <Box flex="1" textAlign="right" display={{ base: "none", md: "block" }}>
                                    <Text color="gray.500">
                                        {new Date(user.created_at).toLocaleDateString("ja-JP")}
                                    </Text>
                                </Box>
                            </Flex>
                        </Link>
                    ))}
                </Stack>
            </Box>
        </Box>
    );
};

UserList.layout = (page: React.ReactNode) => (
    <MainLayout title="ユーザー一覧">{page}</MainLayout>
);

export default UserList;
