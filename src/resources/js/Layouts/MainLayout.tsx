import React, { ReactNode } from "react";
import { Box, Heading, Text, Menu, MenuButton, MenuList, MenuItem, IconButton, Image } from "@chakra-ui/react";
import { HamburgerIcon, Icon } from '@chakra-ui/icons';
import { Link, router, usePage, Head } from "@inertiajs/react";
import { FaLeaf, FaUserPlus, FaUserCircle, FaBookmark } from "react-icons/fa";
import { TbDoorEnter, TbDoorExit } from "react-icons/tb";
import { GiFarmTractor } from "react-icons/gi";
import { PiPlantLight } from "react-icons/pi";

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
    const isMyFarms = component === "Farm/MyFarms";
    const isProfile = component === "Auth/Profile";

    const hasCustomBg = isFarmDetail || isFavoriteReview || isMyFarms || isProfile;

    return (
        <Box
            minH={"100vh"}
            display={"flex"}
            flexDirection={"column"}
        >

            <Head title={title} />

            {/* ヘッダー */}
            <Box
                bg={"green.800"}
                display={"flex"}
                justifyContent={"space-between"}
                alignItems={"center"}
                position={"fixed"}
                w={"100%"}
                height={"70px"}
                zIndex={999}
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
                        <Image src="/images/farmTopIcon.png" alt="ファームアイコン" w={"60px"} h={"60px"} borderRadius={"full"} mx={{ base: 3, xl: 5 }} />
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
                                    onClick={() => router.get("/farm/create")}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    ファーム登録
                                    <Icon as={GiFarmTractor} />
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.get("/farm/myFarms")}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    登録したファーム
                                    <Icon as={PiPlantLight} />
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.get("/review/favorites")}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    お気に入りレビュー
                                    <Icon as={FaBookmark} />
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.get("/profile")}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    プロフィール
                                    <Icon as={FaUserCircle} />
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.post(route("logout"))}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    ログアウト
                                    <Icon as={TbDoorExit} />
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
                                    justifyContent={"space-between"}
                                >
                                    ファーム一覧
                                    <Icon as={FaLeaf} />
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.visit(route("login"))}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    ログイン
                                    <Icon as={TbDoorEnter} />
                                </MenuItem>
                                <MenuItem
                                    onClick={() => router.visit(route("register"))}
                                    fontSize={"18px"}
                                    justifyContent={"space-between"}
                                >
                                    新規登録
                                    <Icon as={FaUserPlus} />
                                </MenuItem>
                            </MenuList>
                        </Menu>
                    </Box>
                }
                {auth.user ?
                    /* PC ログイン*/
                    <Box
                        display={{ base: "none", md: "flex" }}
                        alignItems={"center"}
                        pr={2}
                        fontSize={{ base: "none", md: "16px", xl: "20px" }}>
                        <Icon as={GiFarmTractor}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("farm.create")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ファーム登録
                        </Text>
                        <Icon as={PiPlantLight}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("farm.myFarms")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            登録したファーム
                        </Text>
                        <Icon as={FaBookmark}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("review.favorites")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            お気に入りレビュー
                        </Text>
                        <Icon as={FaUserCircle}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("profile")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            プロフィール
                        </Text>
                        <Icon as={TbDoorExit}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("logout")}
                            pr={2}
                            method="post"
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ログアウト
                        </Text>
                    </Box>
                    /* PC 未ログイン*/
                    : <Box
                        display={{ base: "none", md: "flex" }}
                        alignItems="center"
                        fontSize={{ base: "none", md: "16px", xl: "20px" }}
                        pr={2}>
                        <Icon as={FaLeaf}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("home")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ファーム一覧
                        </Text>
                        <Icon as={TbDoorEnter}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("login")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            ログイン
                        </Text>
                        <Icon as={FaUserPlus}
                            mr={1} color={"white"} />
                        <Text
                            as={Link}
                            color={"white"}
                            _hover={{ opacity: 0.9 }}
                            href={route("register")}
                            mr={{ base: "none", md: 2, xl: 4 }}
                        >
                            新規登録
                        </Text>
                    </Box>
                }
            </Box>
            <Box
                as="main"
                flexGrow={1}
                pt={"70px"}
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
                        &copy; AUSSIE FARM NAVI<br />
                        掲載されている情報はユーザー投稿に基づいています
                    </Text>
                </Box>
            </Box>
        </Box>
    );
};

export default MainLayout;
