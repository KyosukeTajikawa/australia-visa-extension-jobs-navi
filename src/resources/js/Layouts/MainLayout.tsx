import React, { ReactNode } from "react";
import { Box, Heading, Text, Menu, MenuButton, MenuList, MenuItem, IconButton } from "@chakra-ui/react";
import { HamburgerIcon } from '@chakra-ui/icons';
import { Link, router, usePage, } from "@inertiajs/react";

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
                        ファーム一覧
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
                                    onClick={() => router.get("/review/favorites")}
                                >
                                    お気に入りレビュー
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
                                icon={<HamburgerIcon
                                    color={"white"}
                                />}
                                variant={"ghost"}
                                _hover={{ bg: "green.600" }}
                                _active={{ bg: "green.600" }}
                            />
                            <MenuList>
                                <MenuItem
                                    onClick={() => router.visit(route("home"))}
                                >
                                    ファーム一覧
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.visit(route("login"))}
                                >
                                    ログイン
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.visit(route("register"))}
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
                            pr={2}
                        >
                            ファーム登録
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("review.favorites")}
                            pr={2}
                        >
                            お気に入りレビュー
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("logout")}
                            pr={2}
                            method="post"
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
                            pr={2}
                        >
                            ファーム一覧
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("login")}
                            pr={2}
                        >
                            ログイン
                        </Text>
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("register")}
                            pr={2}
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
