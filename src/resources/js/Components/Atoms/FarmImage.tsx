import React from 'react';
import { Image } from '@chakra-ui/react';

type FarmImageProps = {
    url: string;
    name:string;
}


const FarmImage = ({url, name}: FarmImageProps) => {
    return (
        <Image
            src={url}
            alt={name}
            w={{ base: "full" }}
            h={{ base: "200px", sm: "300px", md: "200px", xl: "300px" }}
            objectFit={"cover"}
            onError={(e) => {
                (e.currentTarget as HTMLImageElement).src = "https://placehold.co/300x300";
            }}
        />
    );
}

export default FarmImage;
