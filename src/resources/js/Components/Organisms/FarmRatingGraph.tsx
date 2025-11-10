
import React, { useMemo } from "react";
import { HStack, Text, VStack, Progress, } from "@chakra-ui/react";
import { StarIcon } from "@chakra-ui/icons";

type Review = {
    farm_rating: number;
}

type FarmRatingGraphProps = { reviews?: Review[]; };

const FarmRatingGraph = ({ reviews }: FarmRatingGraphProps) => {
    //配列作成[4, 2, 3, 1, 5]
    const farmRatings = reviews?.map((review) => review.farm_rating) ?? [];
    //評価数を取得
    const total = farmRatings.length;

    const { avg, percents } = useMemo(() => {
        //レビューがなkったら終了
        if (total === 0) return { avg: 0, counts: [0, 0, 0, 0, 0], percents: [0, 0, 0, 0, 0] };

        //全ての評価を足して、評価件数で割る
        const avg = Math.round((farmRatings.reduce((total, item) => total + item, 0) / total) * 10) / 10;
        //それぞれの評価件数を取得[3, 2, 1, 1, 0]
        const counts = [5, 4, 3, 2, 1].map((number) => farmRatings.filter((rating) => rating === number).length);
        //評価件数が一番多いレビュー
        const max = Math.max(...counts);
        //グラフの色の割合を決める種のそれぞれの％
        const percents = counts.map((count) => (max ? (count / max) * 100 : 0));
        return { avg, counts, percents };
        //farmRatingsとtotalに変更があれば再度実行処理
    }, [farmRatings, total]);

    return (
        <HStack align="flex-start" spacing={8} mt={4} mb={6}>
            <VStack align="flex-start">
                <Text fontSize="6xl" fontWeight="bold" lineHeight="1">{avg.toFixed(1)}</Text>
                <HStack>
                    {Array(5)
                        .fill(0)
                        .map((_, i) => (
                            <StarIcon
                                key={i}
                                color={i < Math.round(avg) ? "green.500" : "gray.300"}
                                boxSize={5}
                            />
                        ))}
                </HStack>
                <Text color="gray.600" fontSize="sm">{total.toLocaleString()} 件のレビュー</Text>
            </VStack>

            <VStack flex="1" spacing={2} align="stretch">
                {[5, 4, 3, 2, 1].map((star, idx) => (
                    <HStack key={star} spacing={3}>
                        <Text w="16px" textAlign="right" fontSize="sm">{star}</Text>
                        <Progress
                            value={percents[idx]}
                            flex="1"
                            size="md"
                            borderRadius="md"
                            colorScheme="green"
                            bg="gray.200"
                        />
                    </HStack>
                ))}
            </VStack>
        </HStack>
    );
};

export default FarmRatingGraph;
