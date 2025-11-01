import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmStreetAddressProps = {
    street_address: string;
}

const FarmStreetAddress = ({ street_address }: FarmStreetAddressProps) => {
    return (
        <Text>住所：{street_address}</Text>
    );
};

export default FarmStreetAddress;
