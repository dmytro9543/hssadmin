/**
 * A JavaScript implementation of the Secure Hash Algorithm, SHA-256, as defined
 * in FIPS 180-2
 * Author: Lee Huisung
 * Date: Oct. 5, 2020.
 *
 */
var pol_sha256 = function(){
	
	//Member variables
	var K;
	var W;
	var _a, _b, _c, _d, _e, _f, _g, _h;
	var _block;
	var _finalSize;
	var _blockSize;
	var _len;
	
	return {
		/* SHA256 initialization function.
		 * Initializes all member variables.
		 */
		SHA256_init: function () {
			this._a = 0x6a09e667;
			this._b = 0xbb67ae85;
			this._c = 0x3c6ef372;
			this._d = 0xa54ff53a;
			this._e = 0x510e527f;
			this._f = 0x9b05688c;
			this._g = 0x1f83d9ab;
			this._h = 0x5be0cd19;
			this._block=new Array(64);
			this.W=new Array(64);
			this._finalSize=56;
			this._blockSize=64;
			this._len=0;
			this.K=[
				0x428A2F98, 0x71374491, 0xB5C0FBCF, 0xE9B5DBA5,
				0x3956C25B, 0x59F111F1, 0x923F82A4, 0xAB1C5ED5,
				0xD807AA98, 0x12835B01, 0x243185BE, 0x550C7DC3,
				0x72BE5D74, 0x80DEB1FE, 0x9BDC06A7, 0xC19BF174,
				0xE49B69C1, 0xEFBE4786, 0x0FC19DC6, 0x240CA1CC,
				0x2DE92C6F, 0x4A7484AA, 0x5CB0A9DC, 0x76F988DA,
				0x983E5152, 0xA831C66D, 0xB00327C8, 0xBF597FC7,
				0xC6E00BF3, 0xD5A79147, 0x06CA6351, 0x14292967,
				0x27B70A85, 0x2E1B2138, 0x4D2C6DFC, 0x53380D13,
				0x650A7354, 0x766A0ABB, 0x81C2C92E, 0x92722C85,
				0xA2BFE8A1, 0xA81A664B, 0xC24B8B70, 0xC76C51A3,
				0xD192E819, 0xD6990624, 0xF40E3585, 0x106AA070,
				0x19A4C116, 0x1E376C08, 0x2748774C, 0x34B0BCB5,
				0x391C0CB3, 0x4ED8AA4A, 0x5B9CCA4F, 0x682E6FF3,
				0x748F82EE, 0x78A5636F, 0x84C87814, 0x8CC70208,
				0x90BEFFFA, 0xA4506CEB, 0xBEF9A3F7, 0xC67178F2
				];
		},
		
		/*SHA256 update*/
		SHA256_update: function(data){
			var block = this._block;
			var blockSize = this._blockSize;
			var length = data.length;
			var accum = this._len;

			for (var offset = 0; offset < length;) {
				var assigned = accum % blockSize;
				var remainder = Math.min(length - offset, blockSize - assigned);

				for (var i = 0; i < remainder; i++) {
					block[assigned + i] = data[offset + i];
				}

				accum += remainder;
				offset += remainder;

				if ((accum % blockSize) === 0) {
					this._update(block);
				}
			}
			this._len += length;
		},
		
		_update: function (M) {
			var a = this._a | 0;
			var b = this._b | 0;
			var c = this._c | 0;
			var d = this._d | 0;
			var e = this._e | 0;
			var f = this._f | 0;
			var g = this._g | 0;
			var h = this._h | 0;
			var W = this.W;
			
			for (var i = 0; i < 16; ++i) 
				W[i] = this.readInt32BE(M,i * 4);
			for (; i < 64; ++i) 
				W[i] = (this.gamma1(W[i - 2]) + W[i - 7] + this.gamma0(W[i - 15]) + W[i - 16]) | 0;

			for (var j = 0; j < 64; ++j) {
				var T1 = (h + this.sigma1(e) + this.ch(e, f, g) + this.K[j] + W[j]) | 0;
				var T2 = (this.sigma0(a) + this.maj(a, b, c)) | 0;

				h = g;
				g = f;
				f = e;
				e = (d + T1) | 0;
				d = c;
				c = b;
				b = a;
				a = (T1 + T2) | 0;
			}

			this._a = (a + this._a) | 0;
			this._b = (b + this._b) | 0;
			this._c = (c + this._c) | 0;
			this._d = (d + this._d) | 0;
			this._e = (e + this._e) | 0;
			this._f =  (f + this._f)  | 0;
			this._g = (g + this._g) | 0;
			this._h = (h + this._h) | 0;
		},
		
		/*Digest function, which is called prior to sha256_update, actually does some
		 * zero padding and generate the ultimate hash.
		 */
  		SHA256_digest: function(){
			var rem = this._len % this._blockSize;
			this._block[rem] = 0x80;

			// zero (rem + 1) trailing bits, where (rem + 1) is the smallest
			// non-negative solution to the equation (length + 1 + (rem + 1)) === finalSize mod blockSize
			//For some old web browers, fill does not work for arrays.
			//this._block.fill(0, rem + 1);
			this.fill(this._block, 0, rem+1 );

			if (rem >= this._finalSize) {
				this._update(this._block);
				//this._block.fill(0);
				this.fill(this._block, 0, 0);
			}

			var bits = this._len * 8;

			// uint32
			if (bits <= 0xffffffff) {
				this.writeUInt32BE(this._block, bits, this._blockSize - 4);
			// uint64
			} else {
				var lowBits = (bits & 0xffffffff) >>> 0;
				var highBits = (bits - lowBits) / 0x100000000;

				this.writeUInt32BE(this._block,highBits, this._blockSize - 8);
				this.writeUInt32BE(this._block,lowBits, this._blockSize - 4);
			}

			this._update(this._block);
			var hash = this._hash();

			return hash;
  		},
  			
		_hash: function () {
			var H = new Array(32);

			this.writeInt32BE(H, this._a, 0);
			this.writeInt32BE(H,this._b, 4);
			this.writeInt32BE(H,this._c, 8);
			this.writeInt32BE(H,this._d, 12);
			this.writeInt32BE(H,this._e, 16);
			this.writeInt32BE(H,this._f, 20);
			this.writeInt32BE(H,this._g, 24);
			this.writeInt32BE(H,this._h, 28);

			return H;
		},
		
		/*Util functions*/
		fill: function(array, val, offset){
			for(var i=offset;i<array.length;i++)
				array[i]=val;
		},
		ch: function (x, y, z) {
		  return z ^ (x & (y ^ z))
		},

		maj : function(x, y, z) {
		  return (x & y) | (z & (x | y))
		},

		sigma0: function (x) {
		  return (x >>> 2 | x << 30) ^ (x >>> 13 | x << 19) ^ (x >>> 22 | x << 10)
		},

		sigma1: function (x) {
		  return (x >>> 6 | x << 26) ^ (x >>> 11 | x << 21) ^ (x >>> 25 | x << 7)
		},

		gamma0: function (x) {
		  return (x >>> 7 | x << 25) ^ (x >>> 18 | x << 14) ^ (x >>> 3)
		},

		gamma1: function (x) {
		  return (x >>> 17 | x << 15) ^ (x >>> 19 | x << 13) ^ (x >>> 10)
		},
		
		readInt32BE: function(M, offset){
			  return (M[offset] << 24) | (M[offset + 1] << 16) | (M[offset + 2] << 8) | (M[offset + 3]);
		},
		writeInt32BE: function(M, value, offset){
			if (value < 0) value = 0xffffffff + value + 1;
		    M[offset] = (value >>> 24)
		    M[offset + 1] = (value >>> 16)
		    M[offset + 2] = (value >>> 8)
		    M[offset + 3] = (value & 0xff)
		},
		writeUInt32BE: function(M, value, offset){
		    M[offset] = (value >>> 24)
		    M[offset + 1] = (value >>> 16)
		    M[offset + 2] = (value >>> 8)
		    M[offset + 3] = (value & 0xff)
		},
	};
}();

