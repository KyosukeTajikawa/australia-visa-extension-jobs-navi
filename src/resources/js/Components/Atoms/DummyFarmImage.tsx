import React from 'react';
import { Image } from '@chakra-ui/react';

type DummyFarmImageProps = {
    name: string;
}


const DummyFarmImage = ({ name }: DummyFarmImageProps) => {
    return (
                        <Image
                            src={"https://placehold.co/300x300"}
                            alt={name}
                            w={{ base: "full" }}
                            h={{ base: "200px", sm: "300px", md: "200px", xl: "300px" }}
                            objectFit={"cover"}
                        />
    );
}

export default DummyFarmImage;
