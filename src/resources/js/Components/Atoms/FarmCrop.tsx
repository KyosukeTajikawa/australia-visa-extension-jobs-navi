import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmCropProps = {
    name: string;
}

const FarmCrop = ({ name }: FarmCropProps) => {
    return (
        <Text>{name}</Text>
    );
};

export default FarmCrop;
