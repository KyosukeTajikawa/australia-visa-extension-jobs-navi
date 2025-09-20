import React from "react";
import {
    Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Menu, MenuButton, MenuList, MenuItem, IconButton, Drawer,
    DrawerBody, DrawerOverlay, DrawerContent, DrawerCloseButton, useDisclosure
} from "@chakra-ui/react";
import { HamburgerIcon } from '@chakra-ui/icons';

const MainLayout = ({ children }) => {
    const { isOpen, onOpen, onClose } = useDisclosure()
    return (
        <Box m={2}>
            {/* ヘッダー */}
            <Box bg={"green.500"} p={"4px"} mb={2} display={"flex"} justifyContent={"space-between"} alignItems={"center"}>
                <Heading as={"h1"} color={"white"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>ファーム一覧</Heading>
                {/* SPメニュー */}
                <Box display={{ base: "block", md: "none" }}>
                    <Menu>
                        <MenuButton as={IconButton} aria-label="Options" icon={<HamburgerIcon color={"white"} />} variant={"ghost"} _hover={{ bg: "green.300" }} _active={{ bg: "green.300" }} />
                        <MenuList>
                            <MenuItem>ログイン</MenuItem>
                            <MenuItem>新規登録</MenuItem>
                        </MenuList>
                    </Menu>
                </Box>
                {/* PCメニュー */}
                <Box display={{ base: "none", md: "block" }}>
                    <Button colorScheme='teal' onClick={onOpen} bg={"green.500"} _hover={{ bg: "green.300" }}>
                        <HamburgerIcon />
                    </Button>
                    <Drawer isOpen={isOpen} onClose={onClose}>
                        <DrawerOverlay />
                        <DrawerContent>
                            <DrawerCloseButton />
                            <DrawerBody mt={"60px"} align={"center"} w={"100%"}>
                                <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                    <Link _hover={{ color: "none" }}>
                                        <Text>ログイン</Text>
                                    </Link>
                                </Box>
                                <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                    <Link _hover={{ color: "none" }}>
                                        <Text>新規登録</Text>
                                    </Link>
                                </Box>
                            </DrawerBody>
                        </DrawerContent>
                    </Drawer>
                </Box>
            </Box>
            <Box></Box>
        </Box>
    );
};

export default MainLayout;
