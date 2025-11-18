import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmPostcodeProps = {
    postcode: string;
}

const FarmPostcode = ({ postcode }: FarmPostcodeProps) => {
    return (
        <Text>{postcode}</Text>
    );
};

export default FarmPostcode;
