import React, { ReactNode } from "react";
import {
    Box, Heading, Text, Button, Menu, MenuButton, MenuList, MenuItem, IconButton, Drawer, DrawerHeader,
    DrawerBody, DrawerOverlay, DrawerContent, DrawerCloseButton, useDisclosure
} from "@chakra-ui/react";
import { HamburgerIcon, ChevronDownIcon } from '@chakra-ui/icons';
import { Link, router, usePage, } from "@inertiajs/react";

type MainLayoutProps = {
    children: ReactNode;
    title?: string;
}

const MainLayout = ({ children, title = 'ファーム情報サイト' }: MainLayoutProps) => {
    const { auth } = usePage().props;
    const { isOpen, onOpen, onClose } = useDisclosure()
    return (
        <Box m={2} minH={"98vh"} display={"flex"} flexDirection={"column"}>
            {/* ヘッダー */}
            <Box bg={"green.500"} p={"4px"} mb={2} display={"flex"} justifyContent={"space-between"} alignItems={"center"}>
                <Link href={route("home")}>
                <Heading as={"h1"} color={"white"} fontSize={{ base: "24px", md: "30px", lg: "40px" }} >ファーム一覧</Heading>
                </Link>
                {auth.user ?
                    /* SP ログイン*/
                    < Box display={{ base: "block", md: "none" }}>
                        <Menu>
                            <MenuButton as={IconButton} rightIcon={<ChevronDownIcon color={"white"} />} color={"white"} variant={"ghost"} _hover={{ bg: "green.300" }} _active={{ bg: "green.300" }}>
                                {auth.user.nickname}
                            </MenuButton>
                            <MenuList>
                                <MenuItem onClick={() => router.get("/farm/create")}>ファーム登録</MenuItem>
                                <MenuItem>お気に入りレビュー</MenuItem>
                                <MenuItem onClick={() => router.post(route("logout"))}>ログアウト</MenuItem>
                            </MenuList>
                        </Menu>
                    </Box>
                    /* SP 未ログイン*/
                    : <Box display={{ base: "block", md: "none" }}>
                        <Menu>
                            <MenuButton as={IconButton} aria-label="Options" icon={<HamburgerIcon color={"white"} />} variant={"ghost"} _hover={{ bg: "green.300" }} _active={{ bg: "green.300" }} />
                            <MenuList>
                                <MenuItem onClick={() => router.visit(route("login"))}>ログイン</MenuItem>
                                <MenuItem>新規登録</MenuItem>
                                <MenuItem onClick={() => router.visit(route("home"))}>ファーム一覧</MenuItem>
                            </MenuList>
                        </Menu>
                    </Box>
                }
                {auth.user ?
                    /* PC ログイン*/
                    <Box display={{ base: "none", md: "block" }}>
                        <Button colorScheme='teal' onClick={onOpen} bg={"green.500"} _hover={{ bg: "green.300" }}>
                            <HamburgerIcon />
                        </Button>
                        <Drawer isOpen={isOpen} onClose={onClose}>
                            <DrawerOverlay />
                            <DrawerContent>
                                <DrawerCloseButton />
                                <DrawerHeader>{auth.user.nickname}</DrawerHeader>
                                <DrawerBody mt={"60px"} textAlign={"center"} w={"100%"}>
                                    <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                        <Link _hover={{ color: "none" }} href={route("farm.create")}>
                                            <Text>ファーム登録</Text>
                                        </Link>
                                    </Box>
                                    <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                        <Link _hover={{ color: "none" }}>
                                            <Text>お気に入りレビュー</Text>
                                        </Link>
                                    </Box>
                                    <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                        <Link _hover={{ color: "none" }} href={route("logout")} method="post" onClick={onClose}>
                                            <Text>ログアウト</Text>
                                        </Link>
                                    </Box>
                                </DrawerBody>
                            </DrawerContent>
                        </Drawer>
                    </Box>
                    /* PC 未ログイン*/
                    : <Box display={{ base: "none", md: "block" }}>
                        <Button colorScheme='teal' onClick={onOpen} bg={"green.500"} _hover={{ bg: "green.300" }}>
                            <HamburgerIcon />
                        </Button>
                        <Drawer isOpen={isOpen} onClose={onClose}>
                            <DrawerOverlay />
                            <DrawerContent>
                                <DrawerCloseButton />
                                <DrawerBody mt={"60px"} textAlign={"center"} w={"100%"}>
                                    <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                        <Link _hover={{ color: "none" }} href={route("login")} onClick={onClose}>
                                            <Text>ログイン</Text>
                                        </Link>
                                    </Box>
                                    <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                        <Link _hover={{ color: "none" }}>
                                            <Text>新規登録</Text>
                                        </Link>
                                    </Box>
                                    <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                        <Link _hover={{ color: "none" }} href={route("home")} onClick={onClose}>
                                            <Text>ファーム一覧</Text>
                                        </Link>
                                    </Box>
                                </DrawerBody>
                            </DrawerContent>
                        </Drawer>
                    </Box>
                }
            </Box>
            <Box as="main">{children}</Box>
            {/* Footer */}
            <Box>
                <Box bg="green.500" color={"white"} fontWeight={"bold"} textAlign={"center"} py={{ base: 2, md: 3 }}>
                    <Text fontSize={{ base: 13, md: 16 }}>&copy; 2025 ファーム攻略サイト</Text>
                </Box>
            </Box>
        </Box>
    );
};

export default MainLayout;
