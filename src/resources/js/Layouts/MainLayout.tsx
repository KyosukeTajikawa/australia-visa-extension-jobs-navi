import React, { ReactNode } from "react";
import { Box, Heading, Text, Menu, MenuButton, MenuList, MenuItem, IconButton, Image } from "@chakra-ui/react";
import { HamburgerIcon } from '@chakra-ui/icons';
import { Link, router, usePage, } from "@inertiajs/react";
import { FaLeaf } from "react-icons/fa";

type MainLayoutProps = {
    children: ReactNode;
    title?: string;
}

const MainLayout = ({ children, title = 'ファーム情報サイト' }: MainLayoutProps) => {
    const page = usePage();
    const { auth } = page.props;
    const component = page.component;

    const isFarmDetail = component === "Farm/Detail";
    const isFavoriteReview = component === "Review/FavoriteReview";

    const hasCustomBg = isFarmDetail || isFavoriteReview;

    return (
        <Box
            minH={"98vh"}
            display={"flex"}
            flexDirection={"column"}
        >
            {/* ヘッダー */}
            <Box
                bg={"green.800"}
                p={"4px"}
                display={"flex"}
                justifyContent={"space-between"}
                alignItems={"center"}
            >
                <Text
                    as={Link}
                    href={route("home")}
                    _hover={{ opacity: 0.9 }}
                >
                    <Heading
                        as={"h1"}
                        color={"white"}
                        fontSize={{ base: "24px", md: "30px", lg: "40px" }}
                    >
                        {/* ファーム一覧
                     */}
                        <Image src="/images/farmTopIcon.png" alt="ファームアイコン" w={{ base: "80px", xl: "100px" }} h={{ base: "80px", xl: "100px" }} borderRadius={"full"} mt={2} mx={{ base: 3, xl: 5 }} />
                    </Heading>
                </Text>
                {auth.user ?
                    /* SP ログイン*/
                    <Box
                        display={{ base: "block", md: "none" }}
                        pr={3}
                    >
                        <Menu>
                            <MenuButton
                                as={IconButton}
                                color={"white"}
                                variant={"ghost"}
                                fontSize={"80px"}
                                _hover={{ bg: "green.600" }}
                                _active={{ bg: "green.600" }}
                            >
                                {auth.user.nickname}
                            </MenuButton>
                            <MenuList>
                                <MenuItem
                                    onClick={() => router.get("/farm/create")}
                                >
                                    ファーム登録
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.get("/farm/myFarms")}
                                >
                                    あなたのファーム
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.get("/review/favorites")}
                                >
                                    お気に入りレビュー
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.get("/profile")}
                                >
                                    プロフィール
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.post(route("logout"))}
                                >
                                    ログアウト
                                </MenuItem>
                            </MenuList>
                        </Menu>
                    </Box>
                    /* SP 未ログイン*/
                    : <Box
                        display={{ base: "block", md: "none" }}
                    >
                        <Menu>
                            <MenuButton
                                as={IconButton}
                                mr={3}
                                icon={<HamburgerIcon
                                    color={"white"}
                                    fontSize={"50px"}
                                />}
                                variant={"ghost"}
                                _hover={{ bg: "green.600" }}
                                _active={{ bg: "green.600" }}
                            />
                            <MenuList>
                                <MenuItem
                                    onClick={() => router.visit(route("home"))}
                                    fontSize={"18px"}
                                >
                                    ファーム一覧
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.visit(route("login"))}
                                    fontSize={"18px"}

                                >
                                    ログイン
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.visit(route("register"))}
                                    fontSize={"18px"}

                                >
                                    新規登録
                                </MenuItem>
                            </MenuList>
                        </Menu>
                    </Box>
                }
                {auth.user ?
                    /* PC ログイン*/
                    <Box display={{ base: "none", md: "flex" }} justifyContent={"center"} pr={2}>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("farm.create")}
                            fontSize={{ base: "none", md: "18px", xl: "25px" }}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ファーム登録
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("farm.myFarms")}
                            fontSize={{ base: "none", md: "18px", xl: "25px" }}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            あなたのファーム
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("review.favorites")}
                            fontSize={{ base: "none", md: "18px", xl: "25px" }}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            お気に入りレビュー
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("profile")}
                            fontSize={{ base: "none", md: "18px", xl: "25px" }}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            プロフィール
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("logout")}
                            pr={2}
                            method="post"
                            fontSize={{ base: "none", md: "18px", xl: "25px" }}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ログアウト
                        </Text>
                    </Box>
                    /* PC 未ログイン*/
                    : <Box display={{ base: "none", md: "block" }} pr={2}>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("home")}
                            fontSize={{ base: "none", md: "20px", xl: "25px" }}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ファーム一覧
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("login")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                            fontSize={{ base: "none", md: "20px", xl: "25px" }}

                        >
                            ログイン
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("register")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                            fontSize={{ base: "none", md: "20px", xl: "25px" }}

                        >
                            新規登録
                        </Text>
                    </Box>
                }
            </Box>
            <Box
                as="main"
                flexGrow={1}
                bg={{ base: hasCustomBg ? "#FAF7F0" : "transparent" }}
            >
                {children}
            </Box>
            {/* Footer */}
            <Box>
                <Box
                    bg="green.800"
                    color={"white"}
                    fontWeight={"bold"}
                    textAlign={"center"}
                    py={{ base: 2, md: 3 }}
                >
                    <Text
                        fontSize={{ base: 13, md: 16 }}
                    >
                        &copy; ファーム攻略サイト
                    </Text>
                </Box>
            </Box>
        </Box>
    );
};

export default MainLayout;
