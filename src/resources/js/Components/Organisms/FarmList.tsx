import React from 'react';
import { Box, Text, HStack } from '@chakra-ui/react';
import FarmCrop from '../Atoms/FarmCrop';
import FarmPhoneNumber from '../Atoms/FarmPhoneNumber';
import FarmEmail from '../Atoms/FarmEmail';
import FarmStreetAddress from '../Atoms/FarmStreetAddress';
import FarmSuburb from '../Atoms/FarmSuburb';
import FarmState from '../Atoms/FarmState';
import FarmPostcode from '../Atoms/FarmPostcode';
import FarmDescription from '../Atoms/FarmDescription';

type Crops = {
    id: number;
    name: string;
}

type State = {
    id: number;
    name: string;
}

type Farm = {
    id: number;
    name: string;
    phone_number?: string;
    email?: string;
    description: string;
    street_address: string;
    suburb: string;
    postcode: string;
    state: State;
    crops: Crops[];
    latitude?: number | string | null;
    longitude?: number | string | null;
};

type FarmListProps = {
    farm: Farm;
}

const FarmMap = ({ farm }: { farm: Farm }) => {
    // ① 緯度経度があるか確認（あるなら座標優先）
    const hasLatLng = farm.latitude != null && farm.longitude != null;

    // ② 住所を組み立て（lat/lngがない時の保険）
    const address = `${farm.street_address},${farm.suburb},${farm.state?.name ?? ""}, ${farm.postcode}, Australia`;


    // ③ iframeのsrcを作る（lat/lngがあればそれ、なければ住所）
    const src = hasLatLng
        ? `https://www.google.com/maps?q=${farm.latitude},${farm.longitude}&z=15&output=embed`
        : `https://www.google.com/maps?q=${encodeURIComponent(address)}&z=15&output=embed`;

    // ④ 住所も緯度経度も無いなら何も表示しない（安全）
    if (!hasLatLng && !farm.street_address) return null;

    return (
        <>
            <Box mt={4}>
                <Text mb={2} fontWeight={"bold"}>地図</Text>
                <Box borderRadius={"md"} overflow={"hidden"}>
                    <iframe src={src} title="farm_map" width={"100%"} height={"320"} style={{border: 0}} loading="lazy" />
                </Box>
            </Box>
        </>

    )

}


const FarmList = ({ farm }: FarmListProps) => {
    return (
        <Box>
            <Box
                mx={"auto"}
                w={{ base: "90%", sm: "100%", md: "98%", xl: "95%" }}
                fontSize={"20px"}
                letterSpacing={1}
            >
                <Box
                    display={"flex"}
                    alignItems={"center"}
                >
                    取扱作物：
                    {farm.crops.map((crop) => (
                        <Box
                            key={crop.id}
                            px={2}
                            py={1}
                        >
                            <FarmCrop name={crop.name} />
                        </Box>
                    ))}
                </Box>
                <FarmPhoneNumber phone_number={farm.phone_number} />
                <FarmEmail email={farm.email} />
                <HStack mb={1}>
                    <FarmStreetAddress street_address={farm.street_address} />
                    <FarmSuburb suburb={farm.suburb} />
                    <FarmState name={farm.state.name} />
                    <FarmPostcode postcode={farm.postcode} />
                </HStack>
                <Text mb={1}>説明</Text>
                <FarmDescription description={farm.description} />

                    <FarmMap farm={farm} />



            </Box>
        </Box>
    );
}

export default FarmList;
