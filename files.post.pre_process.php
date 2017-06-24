$payload = $event['request']['payload'];

if(!empty($payload['resource'])){
    foreach($payload['resource'] as $record){
        $ifp = fopen( '/tmp/'.$record['name'], 'wb' );
        
        
        
        if(array_key_exists('content', $record)){
            fwrite( $ifp, base64_decode( $record['content'] ) );
            fclose( $ifp ); 
            
            $source_image = imagecreatefromjpeg('/tmp/'.$record['name']);
        	$width = imagesx($source_image);
        	$desired_width=$width/2;
        	$height = imagesy($source_image);
    	
        	/* find the "desired height" of this thumbnail, relative to the desired width  */
        	$desired_height = floor($height * ($desired_width / $width));
    	
        	/* create a new, "virtual" image */
        	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
    	    $thumb_image = imagecreatetruecolor(256, 256);
    	    
    	    /* copy source image at a resized size */   
    	    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
    	
    	    /* create the physical thumbnail image to its destination */
    	    imagejpeg($virtual_image, '/opt/bitnami/apps/dreamfactory/htdocs/public/files/imagenes/50_'.$record['name']);    
            
            /*genera thubnail*/
            imagecopyresampled($thumb_image, $source_image, 0, 0, 0, 0, 256, 256, $width, $height);
            imagejpeg($thumb_image, '/opt/bitnami/apps/dreamfactory/htdocs/public/files/imagenes/thumb_'.$record['name']);    
            
            unlink('/tmp/'.$record['name']);
        }
        
    }
}
    
