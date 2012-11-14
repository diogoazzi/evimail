<?php
/**
 * Classe responsável pela obtenção de URls e Pastas do servidos dos elementos multimedia (avatar, podcast)
 * @author Diogo Azzi
 */
class Fet_Controller_Helper_Location extends Zend_Controller_Action_Helper_Abstract {
	
	/**
	 * Obtem o diretorio base dos repositórios
	 * @return unknown_type
	 */
	public static function getRepositoryDirectory($uri = null)
	{
		$baseUri = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'repositorio';

		if($uri)
			return $baseUri.DIRECTORY_SEPARATOR.$uri;
			
		return $baseUri;
	}
	
	
	/**
	 * Obtem o diretorio base dos repositórios
	 * @return unknown_type
	 */
	public static function getRepositoryBaseUrl($url = null)
	{
		$baseUrl = '/repositorio';
		if($url)
			return $baseUrl.$url;
			
		return 	$baseUrl;	
	}	

	/**
	 * Obtem o endereço local do thumbnail do vídeo
	 * @return unknown_type
	 */
	public static function getVideoThumbnailLocalPath($videoId, $userId)
	{
		return self::getUserRepositoryLocalPath($userId).'/videos/thumbs/'.md5('localThumb'.$videoId.'-'.$userId.'endLocalThumb').'.jpg';
	}
	
	/**
	 * Obtem o caminho base no servidor onde o vídeo está armazenado. Ps.: Não retorna o caminho completo do arquivo
	 * @param $videoId
	 * @param $userId
	 * @return unknown_type
	 */
	public static function getVideoLocalPath($videoId, $userId)
	{
		return self::getUserRepositoryLocalPath($userId).'/videos/'.$videoId;
	}
	
	/**
	 * Obtem o endereço em disco do arquivo de imagem do avatar do usuário
	 * @param $userId
	 * @return unknown_type
	 */
	public static function getUserAvatarLocalPath($userId)
	{
		return self::getUserRepositoryLocalPath($userId).DIRECTORY_SEPARATOR."avatar";
	}
	
	/**
	 * Obtem o endereço em disco do diretorio de imagens temporárias do usuário
	 * @param $userId
	 * @return unknown_type
	 */
	public static function getUserTempLocalPath($userId)
	{
		return self::getUserRepositoryLocalPath($userId).DIRECTORY_SEPARATOR."tmp";
	}
	
	/**
	 * 
	 * @param $userId
	 * @return unknown_type
	 */
	public static function getUserAvatarLocalUrl($userId)
	{
		return self::getUserRepositoryBaseUrl($userId)."/avatar";
	}
	
	public static function getUserTempLocalUrl($userId)
	{
		return self::getUserRepositoryBaseUrl($userId)."/tmp";
	}
	
	public static function getVideoThumbnailLocalUrl($videoId, $userId)
	{
		return self::getUserRepositoryBaseUrl($userId).'/videos/thumbs/'.md5('localThumb'.$videoId.'-'.$userId.'endLocalThumb').'.jpg';
	}
	
	public static function getVideoLocalUrl($videoId, $userId)
	{
		return self::getUserRepositoryBaseUrl($userId).'/videos/'.$videoId;
	}
	
	public static function getPhotoThumbnailUrl($userId, $albumId, $photoUri)
	{
		return self::getUserRepositoryBaseUrl($userId).'/albums/'.$albumId.'/thumbs/thumb'.$photoUri;
	}
	
	public static function getPhotoNoteThumbnailUrl($userId, $albumId, $photoUri)
	{
		return self::getUserRepositoryBaseUrl($userId).'/albums/'.$albumId.'/thumbs/thumbnote_'.$photoUri;
	}
	
	public static function getPhotoUrl($userId, $albumId, $photoUri)
	{
		return self::getUserRepositoryBaseUrl($userId).'/albums/'.$albumId.'/'.$photoUri;
		//return self::getUserRepositoryBaseUrl($userId).'/albums/'.$albumId.'/'.md5('localThumb'.$userId.'-'.$albumId.'-'.$photoId.'endLocalThumb').'.jpg';
	}
	
	public static function getThumnUrl($userId, $albumId, $photoUri)
	{
		return self::getUserRepositoryBaseUrl($userId).'/albums/'.$albumId.'/thumbs/thumb'.$photoUri;
	}
	
	public static function getAlbumUrl($userId, $albumId)
	{
		return self::getUserRepositoryBaseUrl($userId).'/albums/'.$albumId.'/';
	}
	
	public static function getAlbumCoverUrl($usrId, $albumId, $coverPhotoUri){
		return self::getPhotoThumbnailUrl($usrId, $albumId, $coverPhotoUri);		
	}
	
	public static function getUserAlbumBaseUrl($usrId, $albumId)
	{
		return self::getUserRepositoryBaseUrl($usrId).'/albums';
	} 
	
	public static function getUserAlbumLocalPath($usrId, $albumId)
	{
		return sprintf('%s/profiles/%d/albums/%d', self::getRepositoryDirectory(), $usrId, $albumId);
	}
	
	public static function getUserAlbumThumbLocalPath($usrId, $albumId)
	{
		return self::getUserAlbumLocalPath($usrId, $albumId).'/thumbs/thumb';
	}
	
	/**
	 * Obtém o diretório de repositório de arquivos do usuário
	 * @return unknown_type
	 */
	public static function getUserRepositoryLocalPath($userId)
	{
		return self::getRepositoryDirectory(sprintf('profiles'.DIRECTORY_SEPARATOR.'%d', $userId));
	}
	
	/**
	 * Obtém o diretório de repositório de arquivos do usuário
	 * @return unknown_type
	 */
	public static function getUserRepositoryBaseUrl($userId)
	{
		return self::getRepositoryBaseUrl('/profiles/'.$userId);
	}
	
	/**
	 * Obtém o diretório de repositório de arquivos do evento
	 * @return unknown_type
	 */
	public static function getEventRepositoryLocalPath($eventId)
	{
		return self::getRepositoryDirectory().DIRECTORY_SEPARATOR.'event_profiles'.DIRECTORY_SEPARATOR.$eventId;
	}
	
	public static function getEventThumbPath($eventId)
	{
		return self::getEventRepositoryLocalPath($eventId)."/thumbs";
	}
	
	public static function getEventRepositoryBaseUrl($eventId)
	{
		return self::getRepositoryBaseUrl('/event_profiles/'.$eventId);
	}
	
	public static function getEventThumbUrl($eventId, $photoUri)
	{
		return self::getEventRepositoryBaseUrl($eventId).'/thumbs/thumb'.$photoUri;
	}
	
	/**
	 * Obtém o diretório de repositório de arquivos do local
	 * @return unknown_type
	 */
	public static function getPlaceRepositoryLocalPath($placeId)
	{
		return self::getRepositoryDirectory().'/place_profiles/'.$placeId;
	}
	
	public static function getPlaceThumbPath($placeId)
	{
		return self::getPlaceRepositoryLocalPath($placeId)."/thumbs";
	}
	
	public static function getPlaceRepositoryBaseUrl($placeId)
	{
		return self::getRepositoryBaseUrl().'/place_profiles/'.$placeId;
	}
	
	public static function getPlaceThumbUrl($placeId, $photoUri)
	{
		return self::getPlaceRepositoryBaseUrl($placeId).'/thumbs/thumb'.$photoUri;
	}
	
	/**
	 * Obtém o diretório de repositório de arquivos do local
	 * @return unknown_type
	 */
	public static function getDrinkRepositoryLocalPath($drinkId)
	{
		return self::getRepositoryDirectory('/drink_profiles/'.$drinkId);
	}
	
	public static function getDrinkThumbPath($drinkId)
	{
		return self::getDrinkRepositoryLocalPath($drinkId)."/thumbs";
	}
	
	public static function getDrinkRepositoryBaseUrl($drinkId)
	{
		return self::getRepositoryBaseUrl('/drink_profiles/'.$drinkId);
	}
	
	public static function getDrinkThumbUrl($drinkId, $photoUri)
	{
		return self::getDrinkRepositoryBaseUrl($drinkId).'/thumbs/thumb'.$photoUri;
	}
	
	public static function getDrinkPhotoUrl($drinkId, $photoUri)
	{
		return self::getDrinkRepositoryBaseUrl($drinkId).'/'.$photoUri;
	}
	
	
	/**
	 * Obtem o endereço local do thumbnail do post
	 * @return unknown_type
	 */
	public static function getBlogPostLocalPath($userId)
	{
		return self::getUserRepositoryLocalPath($userId).'/posts';
	}
	
	/**
	 * 
	 * @param $userId
	 * @return unknown_type
	 */
	public static function getBlogPostLocalUrl($userId)
	{
		return self::getUserRepositoryBaseUrl($userId).'/posts';;
	}
	
	public static function getTagPostCacheFileName($userId, $postId){
		return 'tag_post_userId'.$userId.'_postId'.$postId.'_cache';
	}
	
	public static function getTagBlogCacheFileName($userId){
		return 'tag_blog_userId'.$userId.'_cache';
	}
	
	public static function getTagAllBlogsCacheFileName(){
		return 'tag_blogs_cache';
	}
	
	public static function getTagPostCacheDir($userId, $postId){
		$config = Zend_Registry::get('config');
		return str_replace("#ID#",$userId, $config->tagPostCacheDir);
	}
	
	public static function getTagBlogCacheDir($userId){
		$config = Zend_Registry::get('config');
		return str_replace("#ID#",$userId, $config->tagBlogCacheDir);
	}
	
	public static function getTagAllBlogsCacheDir(){
		$config = Zend_Registry::get('config');
		return $config->tagAllBlogsCacheDir;
	}

	/**
	 * Obtem o endereço no servidor de um determinado arquivo de podcast.
	 * @param $userId
	 * @param $podcastId
	 * @param $podcastFileName
	 * @return string
	 */
	public static function getPodcastLocalPath($userId, $podcastFileName)
	{
		return sprintf('%s/podcasts/%s', self::getUserRepositoryLocalPath($userId), $podcastFileName);
	}
	
	
	/**
	 * Obtem o endereço (URL) do arquivo de podcast
	 * @param $userId
	 * @param $podcastFileName
	 * @return string
	 */
	public static function getPodcastUrl($userId, $podcastFileName)
	{
		return sprintf('%s/podcasts/%s', self::getUserRepositoryBaseUrl($userId), $podcastFileName);		
	}
}