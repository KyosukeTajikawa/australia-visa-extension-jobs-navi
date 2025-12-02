import React, { useMemo } from "react";
import { Box, HStack, Text, VStack, Progress } from "@chakra-ui/react";
import { StarIcon } from "@chakra-ui/icons";

type Review = {
    farm_rating: number;
};

type FarmRatingGraphProps = {
    reviews?: Review[];
};

// 小数を 0.0 / 0.5 / 1.0 に丸める関数
const roundToHalf = (value: number): number => {
    const int = Math.floor(value);
    const decimal = value - int;

    if (decimal <= 0.2) return int;
    if (decimal <= 0.7) return int + 0.5;
    return int + 1;
};

// ★ 1つ分の星（0 / 0.5 / 1 の塗り）
const HalfStar = ({ filled }: { filled: 0 | 0.5 | 1 }) => {
    return (
        <Box
            position="relative"
            w={6}
            h={6}
            display="inline-block"
            lineHeight={0}
        >
            {/* 背景（グレーの星） */}
            <StarIcon color="gray.300" boxSize={6} />

            {/* 前面（緑の星） */}
            {filled > 0 && (
                <Box
                    position="absolute"
                    top={0}
                    left={0}
                    width={`${filled * 100}%`}
                    height="100%"
                    overflow="hidden"
                >
                    <StarIcon color="green.500" boxSize={6} />
                </Box>
            )}
        </Box>
    );
};

const FarmRatingGraph = ({ reviews }: FarmRatingGraphProps) => {
    const farmRatings = reviews?.map((review) => review.farm_rating) ?? [];
    const total = farmRatings.length;

    const { avg, starAvg, percents } = useMemo(() => {
        if (total === 0) {
            return {
                avg: 0,
                starAvg: 0,
                counts: [0, 0, 0, 0, 0],
                percents: [0, 0, 0, 0, 0],
            };
        }

        // 平均値（小数1位まで）
        const rawAvg =
            farmRatings.reduce((sum, rating) => sum + rating, 0) / total;
        const avg = Math.round(rawAvg * 10) / 10;

        // 星表示用に 0.5 刻みに丸める
        const starAvg = roundToHalf(avg);

        // 各星ごとの件数（5,4,3,2,1）
        const counts = [5, 4, 3, 2, 1].map(
            (number) =>
                farmRatings.filter((rating) => rating === number).length
        );

        // 最大件数を基準にパーセントを出す
        const max = Math.max(...counts);
        const percents = counts.map((count) =>
            max ? (count / max) * 100 : 0
        );

        return { avg, starAvg, counts, percents };
    }, [farmRatings, total]);

    return (
        <HStack align="flex-start" spacing={8} mt={4} mb={6}>
            {/* 平均スコア & 星 */}
            <VStack align="flex-start">
                <Text
                    color={"#4D4D4F"}
                    fontSize="6xl"
                    fontWeight="bold"
                    lineHeight="1"
                >
                    {avg.toFixed(1)}
                </Text>

                {/* ★ 総合評価の星 */}
                <HStack spacing={1} lineHeight={0}>
                    {Array.from({ length: 5 }).map((_, i) => {
                        const diff = starAvg - i;

                        let filled: 0 | 0.5 | 1;
                        if (diff >= 1) {
                            filled = 1;
                        } else if (diff >= 0.5) {
                            filled = 0.5;
                        } else {
                            filled = 0;
                        }

                        return <HalfStar key={i} filled={filled} />;
                    })}
                </HStack>

                <Text color="gray.600" fontSize="sm">
                    {total.toLocaleString()} 件のレビュー
                </Text>
            </VStack>

            {/* 棒グラフ */}
            <VStack flex="1" spacing={2} align="stretch">
                {[5, 4, 3, 2, 1].map((star, idx) => (
                    <HStack key={star} spacing={3}>
                        <Text
                            w="16px"
                            textAlign="right"
                            fontSize="sm"
                        >
                            {star}
                        </Text>
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
