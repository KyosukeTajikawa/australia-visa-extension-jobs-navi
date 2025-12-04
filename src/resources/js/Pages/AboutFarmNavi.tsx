import React, { useState, useEffect } from "react";
import { Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Select, Flex, useToast } from "@chakra-ui/react";
import MainLayout from "@/Layouts/MainLayout";
import { router } from "@inertiajs/react";
import { ArrowForwardIcon } from '@chakra-ui/icons';

const AboutFarmNavi = () => {
    return (
        <Box>
            <Box bgImage={"/images/farmLP.png"} bgSize={"cover"} h={{ lg: "670px" }} bgPosition="center" bgRepeat="no-repeat" p={5}>
                <Flex justifyContent={"center"} h={{ md: "640px" }}>
                    <Box my={"auto"} w={"580px"}><Image src={"/images/farmCatchCopy.png"} /></Box>
                    <Box><Image src={"/images/phone1.png"} w={"100%"} h={"100%"} /></Box>
                </Flex>
            </Box>
            <VStack mt={5} spacing={0} mx={5}>
                <Heading as={"h2"} color={"green.800"}>AUSSIE FARM NAVI</Heading>
                <Text as={"span"} mb={3}>オーストオラリアのファーム情報共有サービス</Text>
                <Text>AUSSIE FARM NAVIは、誰でも簡単にファームやレビュー作成・共有できるサービスです。</Text>
                <Text>あなたのワーホリがもっと楽しく、安心できる毎日になるようにサポートします。</Text>
                <Box overflowX={"auto"} w={"100%"} my={10}>
                    <HStack w={{ base: "768px", lg: "990px" }} mx={"auto"} py={5}>
                        <Box minW={{ base: "230px", md: "230px", lg: "300px" }} maxW={{ base: "230px", md: "230px", lg: "300px" }} flexShrink={0} p={5} mx={"auto"}>
                            <Image src="/images/phone1.png" />
                        </Box>
                        <Box minW={{ base: "230px", md: "230px", lg: "300px" }} maxW={{ base: "230px", md: "230px", lg: "300px" }} flexShrink={0} p={5} mx={"auto"}>
                            <Image src="/images/phone4.png" />
                        </Box>
                        <Box minW={{ base: "230px", md: "230px", lg: "300px" }} maxW={{ base: "230px", md: "230px", lg: "300px" }} flexShrink={0} p={5} mx={"auto"}>
                            <Image src="/images/phone5.png" />
                        </Box>
                    </HStack>
                </Box>
            </VStack>
            <VStack>
                <Heading as={"h2"} color={"green.800"}>ファーム作成の手順</Heading>
                <Box overflowX={"auto"} w={"100%"} py={5}>
                    <HStack w={{ base: "768px", lg: "990px" }} mx={"auto"}>
                        <Box minW={{ base: "230px", md: "230px", lg: "300px" }} maxW={{ base: "230px", md: "230px", lg: "300px" }} flexShrink={0} p={5} bg={"green.100"} borderRadius={"30px"} mx={"auto"}>
                            <Image src="/images/phone2.png" />
                            <Text>まずは、ファーム登録を押します。</Text>
                        </Box>
                        <Box minW={{ base: "230px", md: "230px", lg: "300px" }} maxW={{ base: "230px", md: "230px", lg: "300px" }} flexShrink={0} p={5} bg={"green.100"} borderRadius={"30px"} mx={"auto"}>
                            <Image src="/images/phone3.png" />
                            <Text>次に、ファームの情報を入力して登録を押します。</Text>
                        </Box>
                        <Box minW={{ base: "230px", md: "230px", lg: "300px" }} maxW={{ base: "230px", md: "230px", lg: "300px" }} flexShrink={0} p={5} bg={"green.100"} borderRadius={"30px"} mx={"auto"}>
                            <Image src="/images/phone4.png" />
                            <Text>ファームの詳細ページが作成されます。</Text>
                        </Box>
                    </HStack>
                </Box>
            </VStack>
            <VStack mx={5}>
                <Heading as={"h2"} color={"green.800"} mb={2}>開発者のメッセージ</Heading>
                <Text>AUSSIE FARM NAVIにアクセスいただきありがとうございます！開発者のきょうすけと申します。</Text>
                <Text>このサービスは、私自身がワーホリ中に 2nd ビザ取得のためのファーム探しで苦労した経験から、“もっと安心して、もっと簡単に探せる場所をつくりたい”という思いで生まれました。</Text>
                <Text>ユーザーの皆さんが迷わず探せるよう、検索機能・レビュー評価・ファーム情報の見やすい整理など、使いやすさを大切にしています。</Text>
                <Text>AUSSIE FARM NAVIを使うことで、皆さんのワーホリライフが快適になれば、開発者としてはこの上ない喜びです。</Text>
                <Text>それでは、皆さんのワーホリが素晴らしいものになることを祈っています！</Text>
            </VStack>
            <VStack>
                <Button as={Link} w={{ base: "40%", md: "20%" }} bg={"green.800"} _hover={{ bg: "green.700", textDecoration: "none" }} color={"white"} href={route("login")} my={10}>無料で始める</Button>
            </VStack>
        </Box>
    )
};

AboutFarmNavi.layout = (page: React.ReactNode) => (<MainLayout title="AUSSIE FARM NAVI｜オーストラリア ワーホリのファーム探し・レビュー共有サイト">{page}</MainLayout>);
export default AboutFarmNavi;
